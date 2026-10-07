import type { Octokit } from '@octokit/rest'
import { RequestError } from '@octokit/request-error'
import { packages } from '../../app/data/packages'
import type { Package, PackageVersion } from '../../shared/types/packages'
import getLatestStablePackageVersion from '../../shared/utils/getLatestStablePackageVersion'

/**
 * Lists the documentation paths (Markdown files under `docs/`, without the extension) on a package version's
 * branch, leaving out `index.md`, which holds the sidebar navigation rather than a page.
 *
 * Throws the Octokit error when the tree cannot be read, so each caller decides how a missing `docs/`
 * directory or a GitHub failure should be reported.
 */
export async function fetchDocsPaths(octokit: Octokit, pkg: Package, version: PackageVersion): Promise<string[]> {
    const { data } = await octokit.git.getTree({
        owner: pkg.github.owner,
        repo: pkg.github.repo,
        tree_sha: `${version.gitBranch || version.version}:docs`,
        recursive: 'true',
    })

    return data.tree
        .filter(item => item.type === 'blob' && item.path?.endsWith('.md') && item.path !== 'index.md')
        .map(item => item.path!.replace(/\.md$/, ''))
}

/**
 * The route search engines should treat as canonical for a documentation page.
 *
 * Successive versions of a page are near-duplicates — usually a handful of changed lines — so left to
 * self-canonicalize, Google clusters them anyway and picks a representative on its own, often an old or
 * unreleased version. Pointing every version at the latest stable release's copy makes that choice for it.
 * A page the latest stable version no longer has stays canonical to itself, as it duplicates nothing.
 *
 * Shared by the rendered page, its `/raw` twin and the sitemap so all three always agree.
 */
export function canonicalDocsRoute(
    pkg: Package,
    version: string,
    path: string,
    latestStablePaths: ReadonlySet<string>,
): string {
    const latestStable = getLatestStablePackageVersion(pkg)
    const canonicalVersion = latestStable && latestStablePaths.has(path) ? latestStable.version : version

    return `/open-source/packages/${pkg.slug}/docs/${canonicalVersion}/${path}`
}

/**
 * Walks the `docs/` tree of every visible, documented package version on GitHub and returns the list of
 * documentation routes (the version index plus one route per Markdown file).
 *
 * Shared by the sitemap source handler and the Nitro `prerender:routes` hook so the prerenderer and the sitemap
 * stay in sync from a single discovery pass. The caller supplies the Octokit client so this stays free of Nitro
 * runtime auto-imports and can therefore run inside the build-time prerender hook too.
 */
export async function discoverDocsRoutes(octokit: Octokit): Promise<string[]> {
    const routes: string[] = []

    for (const pkg of packages) {
        if (!pkg.hasDocumentation || !pkg.visible) {
            continue
        }

        for (const version of pkg.versions) {
            try {
                const docPaths = await fetchDocsPaths(octokit, pkg, version)

                console.debug(`${pkg.name} ${version.version}: Adding ${docPaths.length} pages`)

                // Add index route
                routes.push(`/open-source/packages/${pkg.slug}/docs/${version.version}`)

                // Add routes for each doc file
                for (const docPath of docPaths) {
                    routes.push(`/open-source/packages/${pkg.slug}/docs/${version.version}/${docPath}`)
                }
            } catch (error) {
                if (error instanceof RequestError) {
                    if (error.status === 404) {
                        console.warn(`${pkg.name} ${version.version}: No docs directory found`)
                    } else {
                        console.error(`${pkg.name} ${version.version}: Error fetching docs - ${error.message}`)
                    }
                } else {
                    console.error(`${pkg.name} ${version.version}: Error fetching docs`, error)
                }
            }
        }
    }

    return routes
}

const DOCS_PAGE_ROUTE = /^\/open-source\/packages\/([^/]+)\/docs\/([^/]+)\/(.+)$/

/**
 * Narrows the output of {@link discoverDocsRoutes} to the URLs worth submitting in the sitemap: canonical
 * documentation pages only, as {@link canonicalDocsRoute} decides them.
 *
 * Version index routes are dropped because they only redirect to `intro`, and every other version's copy of
 * a page the latest stable version also has is dropped because it canonicalizes there. Listing either kind
 * asks Google to crawl and index a URL the page itself says not to index, which it reports as a conflict.
 */
export function sitemapDocsRoutes(routes: string[]): string[] {
    const pages = routes.flatMap(route => {
        const match = route.match(DOCS_PAGE_ROUTE)

        return match ? [{ route, slug: match[1]!, version: match[2]!, path: match[3]! }] : []
    })

    return pages
        .filter(page => {
            const pkg = packages.find(p => p.slug === page.slug)

            if (!pkg) {
                return false
            }

            const latestStable = getLatestStablePackageVersion(pkg)
            const latestStablePaths = new Set(
                pages.filter(p => p.slug === page.slug && p.version === latestStable?.version).map(p => p.path),
            )

            return canonicalDocsRoute(pkg, page.version, page.path, latestStablePaths) === page.route
        })
        .map(page => page.route)
}

/**
 * Maps a documentation page route to its raw Markdown twin under `/raw`.
 *
 * Returns `null` for a version index route (`.../docs/{version}`), which only redirects to `intro` in the
 * app and is backed by `docs/index.md` — the sidebar navigation, not page content — so it has no raw
 * representation worth publishing.
 */
export function toRawDocsRoute(route: string): string | null {
    return DOCS_PAGE_ROUTE.test(route) ? `/raw${route}.md` : null
}

/**
 * The `/docs` index route of every documented package, which redirects to the latest version's intro page.
 *
 * Nothing on the site links here — package cards and in-content links both point straight at a version — so
 * `crawlLinks` only reaches it for the odd package whose own documentation happens to link to it, leaving
 * the rest to 404. Enumerating it makes a URL people type and link by hand work for every package.
 *
 * Kept out of {@link discoverDocsRoutes} so the sitemap, which shares that discovery pass, lists only the
 * canonical page URLs rather than a redirect.
 */
export function docsIndexRoutes(): string[] {
    return packages
        .filter(pkg => pkg.hasDocumentation && pkg.visible)
        .map(pkg => `/open-source/packages/${pkg.slug}/docs`)
}

/**
 * Repeats every documentation route of a renamed package under each slug it used to be published under.
 *
 * GitHub Pages serves files and nothing else, so a redirect only exists where a file was written for it.
 * Handling a rename in the page component is therefore only half the job: without a file at the old URL,
 * GitHub Pages answers it with `404.html`, and the component's redirect runs client side behind an HTTP
 * 404 that no crawler will follow. Prerendering the old URL turns that into a 200 whose body redirects.
 *
 * Some of the routes this produces never existed — a page added after the rename gets an old-slug twin
 * too — which costs one small file each and spares us pinning a historical page list that would rot.
 *
 * Kept out of {@link discoverDocsRoutes} for the same reason as {@link docsIndexRoutes}: these are
 * redirects, and the sitemap should only ever advertise where they lead.
 */
export function slugRenameRoutes(routes: string[]): string[] {
    const renameRoutes: string[] = []

    for (const pkg of packages) {
        if (!pkg.previousSlugs?.length || !pkg.hasDocumentation || !pkg.visible) {
            continue
        }

        const docsRoot = `/open-source/packages/${pkg.slug}/docs`

        for (const previousSlug of pkg.previousSlugs) {
            const previousDocsRoot = `/open-source/packages/${previousSlug}/docs`

            renameRoutes.push(previousDocsRoot)

            for (const route of routes) {
                if (route.startsWith(`${docsRoot}/`)) {
                    renameRoutes.push(`${previousDocsRoot}${route.slice(docsRoot.length)}`)
                }
            }
        }
    }

    return renameRoutes
}
