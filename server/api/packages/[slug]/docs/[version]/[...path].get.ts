export default defineCachedEventHandler(
    async event => {
        const doc = await resolveDoc(
            getRouterParam(event, 'slug'),
            getRouterParam(event, 'version'),
            getRouterParam(event, 'path'),
        )

        // Workaround for a Comark bug: single-line `<div class="...">...</div>` gets parsed as an
        // unclosed block-level HTML token, swallowing every block that follows it. Rewriting these
        // callouts as Comark block components renders them correctly. Remove once Comark fixes upstream.
        //
        // This rewrite is deliberately confined to the rendered representation. The `/raw` twin publishes
        // the repository file untouched, which is the whole point of offering it.
        const content = doc.markdown.replace(
            /^<div\s+class="([^"]+)">(.*?)<\/div>\s*$/gm,
            (_match, className: string, inner: string) => `::div{class="${className}"}\n${inner}\n::`,
        )

        return {
            content,
            package: doc.pkg,
            version: doc.pkgVersion,
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
