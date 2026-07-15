import type { Octokit } from '@octokit/rest'
import { RequestError } from '@octokit/request-error'
import { packages } from '../../app/data/packages'

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
            const gitBranch = version.gitBranch || version.version

            try {
                const { data } = await octokit.git.getTree({
                    owner: pkg.github.owner,
                    repo: pkg.github.repo,
                    tree_sha: `${gitBranch}:docs`,
                    recursive: 'true',
                })

                const docFiles = data.tree
                    .filter(item => item.type === 'blob' && item.path?.endsWith('.md'))
                    .map(item => item.path!)
                    .filter(path => path !== 'index.md')

                console.debug(`${pkg.name} ${version.version}: Adding ${docFiles.length} pages`)

                // Add index route
                routes.push(`/open-source/packages/${pkg.slug}/docs/${version.version}`)

                // Add routes for each doc file
                for (const docFile of docFiles) {
                    const docPath = docFile.replace(/\.md$/, '')

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
