import { Octokit } from '@octokit/rest'
import { RequestError } from '@octokit/request-error'
import { packages } from '../app/data/packages'

export default async function discoverDocumentationRoutes(): Promise<string[]> {
    const githubToken = process.env.GITHUB_TOKEN

    if (!githubToken) {
        console.warn('No GITHUB_TOKEN found, skipping route discovery')

        return []
    }

    const octokit = new Octokit({ auth: githubToken })
    const routes: string[] = []

    console.log('🔍 Discovering documentation routes from GitHub...')

    for (const pkg of packages) {
        if (!pkg.hasDocumentation || !pkg.visible) {
            continue
        }

        for (const version of pkg.versions) {
            const gitBranch = version.gitBranch || version.version

            try {
                const { data } = await octokit.git.getTree({
                    owner: 'BabDev',
                    repo: pkg.name,
                    tree_sha: `${gitBranch}:docs`,
                    recursive: 'true',
                })

                const docFiles = data.tree
                    .filter(item => item.type === 'blob' && item.path?.endsWith('.md'))
                    .map(item => item.path!)
                    .filter(path => path !== 'index.md')

                console.debug(`${pkg.name} ${version.version}: Adding ${docFiles.length} pages`)

                // Add index route
                routes.push(`/open-source/packages/${pkg.slug}/docs/${version.version}/`)

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

    console.debug(`Discovered ${routes.length} documentation routes`)

    return routes
}
