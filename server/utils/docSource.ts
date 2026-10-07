import { packages } from '~/data/packages'
import type { Package, PackageVersion } from '#shared/types/packages'

export interface ResolvedDoc {
    pkg: Package
    pkgVersion: PackageVersion
    /** Documentation path with no extension and no leading or trailing slash, e.g. `usage/configuration`. */
    path: string
    /** The Markdown exactly as it is stored in the repository. */
    markdown: string
}

/**
 * Fetches one documentation file from GitHub, cached across every representation that asks for it.
 *
 * The cache lives on the fetch rather than on the route handlers because a single documentation page is
 * requested twice per build — once for the HTML page and once for its `/raw` Markdown twin — and each
 * handler caches under its own key. Without this, prerendering would spend two GitHub API calls per page.
 */
const fetchDocMarkdown = defineCachedFunction(
    (owner: string, repo: string, path: string, ref: string) => fetchRepositoryFile(owner, repo, path, ref),
    {
        maxAge: 60 * 60 * 24, // Cache for 24 hours
        name: 'doc-markdown',
        getKey: (owner: string, repo: string, path: string, ref: string) => `${owner}-${repo}-${ref}-${path}`,
    },
)

/**
 * Lists a package version's documentation paths, cached so that canonicalizing every page of a version
 * costs one GitHub tree read rather than one per page.
 */
const fetchCachedDocsPaths = defineCachedFunction(
    (pkg: Package, version: PackageVersion) => fetchDocsPaths(getGitHubClient(), pkg, version),
    {
        maxAge: 60 * 60 * 24, // Cache for 24 hours
        name: 'docs-paths',
        getKey: (pkg: Package, version: PackageVersion) => `${pkg.slug}-${version.version}`,
    },
)

/**
 * The canonical route for a resolved documentation page; see {@link canonicalDocsRoute} for the rule.
 *
 * When the latest stable version's tree cannot be read the page falls back to canonicalizing itself, which
 * is what every page did before cross-version canonicals, rather than failing the page over SEO metadata.
 */
export async function resolveCanonicalDocRoute(doc: ResolvedDoc): Promise<string> {
    const latestStable = getLatestStablePackageVersion(doc.pkg)
    let latestStablePaths: string[] = []

    if (latestStable && latestStable !== doc.pkgVersion) {
        try {
            latestStablePaths = await fetchCachedDocsPaths(doc.pkg, latestStable)
        } catch (error) {
            console.error(`${doc.pkg.name} ${latestStable.version}: Error listing docs for canonical URL`, error)
        }
    }

    return canonicalDocsRoute(doc.pkg, doc.pkgVersion.version, doc.path, new Set(latestStablePaths))
}

/**
 * Resolves a documentation route to the Markdown file backing it on GitHub, throwing the appropriate
 * HTTP error when any part of the route does not exist.
 *
 * Shared by the HTML page's API endpoint and the `/raw` Markdown twin so the two representations can never
 * disagree about which file a route maps to. The Markdown is returned verbatim; rendering workarounds are
 * the business of the caller that renders it, not of the file we publish as the raw representation.
 */
export async function resolveDoc(
    slug: string | undefined,
    version: string | undefined,
    path: string | undefined,
): Promise<ResolvedDoc> {
    const docPath = (path || 'intro').replace(/^\/+|\/+$/g, '')

    if (!slug || !version) {
        throw createError({ statusCode: 400, message: 'Missing parameters' })
    }

    const pkg = packages.find(p => p.slug === slug)

    if (!pkg) {
        throw createError({ statusCode: 404, message: 'Package not found' })
    }

    if (!pkg.hasDocumentation) {
        throw createError({ statusCode: 404, message: 'Package does not have documentation' })
    }

    const pkgVersion = pkg.versions.find(v => v.version === version)

    if (!pkgVersion) {
        throw createError({ statusCode: 404, message: 'Version not found' })
    }

    // Determine the git branch to fetch from
    const gitBranch = pkgVersion.gitBranch || pkgVersion.version

    const markdown = await fetchDocMarkdown(pkg.github.owner, pkg.github.repo, `docs/${docPath}.md`, gitBranch)

    if (!markdown) {
        throw createError({ statusCode: 404, message: 'Documentation not found' })
    }

    return { pkg, pkgVersion, path: docPath, markdown }
}
