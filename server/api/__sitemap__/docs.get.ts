import type { SitemapUrlInput } from '@nuxtjs/sitemap'

export default defineSitemapEventHandler(async () => {
    const routes = await discoverDocsRoutes(getGitHubClient())

    return routes as SitemapUrlInput[]
})
