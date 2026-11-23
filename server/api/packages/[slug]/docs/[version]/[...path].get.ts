export default defineCachedEventHandler(
    async event => {
        const doc = await resolveDoc(
            getRouterParam(event, 'slug'),
            getRouterParam(event, 'version'),
            getRouterParam(event, 'path'),
        )

        return {
            content: doc.markdown,
            canonicalPath: await resolveCanonicalDocRoute(doc),
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
