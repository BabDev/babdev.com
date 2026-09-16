import type { Package, PackageVersion } from '#shared/types/packages'

/**
 * Human-readable support notices for a package version, mirroring the alerts the rendered page shows.
 *
 * These are site metadata rather than repository content, and they are the one piece of it that changes what
 * a reader should conclude from the documentation: without them an agent reads end-of-life documentation as
 * current and recommends it. They live in the frontmatter so the document body stays byte-identical to the
 * file in the package repository.
 *
 * Each phrasing stays true whenever it is read, which matters because a prerendered file is only as fresh as
 * the build that produced it. The rendered page compares `endOfSupport` against the clock at render time, so
 * on a static build its banner is frozen until the next deploy; stating the support window instead of
 * evaluating it avoids inheriting that staleness here.
 */
function supportNotices(pkg: Package, version: PackageVersion): string[] {
    const notices: string[] = []

    if (!pkg.supported) {
        notices.push(
            `The ${pkg.name} package is no longer supported and will not receive further updates or bug fixes. You are advised to migrate to an alternative solution.`,
        )
    }

    if (!version.released) {
        notices.push(
            `Version ${version.version} of ${pkg.name} has not been released yet. Its API may change before release.`,
        )
    }

    if (version.endOfSupport) {
        const date = version.endOfSupport.slice(0, 10)

        notices.push(
            new Date(version.endOfSupport) < new Date()
                ? `Version ${version.version} of ${pkg.name} reached end of support on ${date}.`
                : `Version ${version.version} of ${pkg.name} is supported until ${date}.`,
        )
    }

    return notices
}

export default defineEventHandler(async event => {
    const slug = getRouterParam(event, 'slug')
    const version = getRouterParam(event, 'version')
    const path = getRouterParam(event, 'path') || ''

    // The `.md` extension is captured by the catch-all rather than written into the filename: Nitro cannot
    // match a route pattern with anything following a catch-all segment, so `[...path].md.get.ts` would
    // never resolve. Stripping it here keeps the twin at `/raw/<page path>.md`.
    if (!path.endsWith('.md')) {
        throw createError({ statusCode: 404, message: 'Documentation not found' })
    }

    const doc = await resolveDoc(slug, version, path.slice(0, -3))

    const siteUrl = useRuntimeConfig(event).public.siteUrl.replace(/\/+$/, '')
    const canonicalUrl = `${siteUrl}/open-source/packages/${doc.pkg.slug}/docs/${doc.pkgVersion.version}/${doc.path}`
    const title = doc.markdown.match(/^#\s+(.+)$/m)?.[1] ?? doc.pkg.name
    const notices = supportNotices(doc.pkg, doc.pkgVersion)

    setHeader(event, 'Content-Type', 'text/markdown; charset=utf-8')

    // Prerendered files are served by GitHub Pages, which sends no custom headers, so this only reaches a
    // client in dev and `pnpm preview`. The frontmatter below is what carries the link back in production.
    setHeader(event, 'Link', `<${canonicalUrl}>; rel="canonical", <${canonicalUrl}>; rel="alternate"; type="text/html"`)

    // Everything below the frontmatter is the repository file, unchanged. `JSON.stringify` is used for the
    // scalars because YAML is a superset of JSON for quoted strings, so it escapes them correctly.
    const frontmatter = [
        '---',
        `title: ${JSON.stringify(title)}`,
        `package: ${JSON.stringify(doc.pkg.name)}`,
        `version: ${JSON.stringify(doc.pkgVersion.version)}`,
        `canonical_url: ${JSON.stringify(canonicalUrl)}`,
        `package_supported: ${doc.pkg.supported}`,
        `version_released: ${doc.pkgVersion.released}`,
        ...(doc.pkgVersion.endOfSupport ? [`end_of_support: ${JSON.stringify(doc.pkgVersion.endOfSupport)}`] : []),
        ...(notices.length ? ['notice:', ...notices.map(notice => `  - ${JSON.stringify(notice)}`)] : []),
        '---',
        '',
    ].join('\n')

    return `${frontmatter}${doc.markdown}`
})
