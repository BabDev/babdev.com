import { packages } from '~/data/packages'

export default defineCachedEventHandler(
    async event => {
        const slug = getRouterParam(event, 'slug')
        const version = getRouterParam(event, 'version')
        const pathParts = getRouterParam(event, 'path')
        const path = (pathParts || 'intro').replace(/\/+$/, '')

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

        const markdown = await fetchRepositoryFile(pkg.github.owner, pkg.github.repo, `docs/${path}.md`, gitBranch)

        if (!markdown) {
            throw createError({ statusCode: 404, message: 'Documentation not found' })
        }

        // Workaround for a Comark bug: single-line `<div class="...">...</div>` gets parsed as an
        // unclosed block-level HTML token, swallowing every block that follows it. Rewriting these
        // callouts as Comark block components renders them correctly. Remove once Comark fixes upstream.
        const content = markdown.replace(
            /^<div\s+class="([^"]+)">(.*?)<\/div>\s*$/gm,
            (_match, className: string, inner: string) => `::div{class="${className}"}\n${inner}\n::`,
        )

        return {
            content,
            package: pkg,
            version: pkgVersion,
        }
    },
    {
        maxAge: 60 * 60 * 24, // Cache for 24 hours
        getKey: event => {
            const slug = getRouterParam(event, 'slug')
            const version = getRouterParam(event, 'version')
            const path = getRouterParam(event, 'path') || 'index'

            return `docs-${slug}-${version}-${path}`
        },
    },
)
