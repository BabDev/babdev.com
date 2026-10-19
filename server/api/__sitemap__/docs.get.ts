import type { SitemapUrlInput } from '#sitemap/server'
import { defineSitemapEventHandler } from '#sitemap/server'

export default defineSitemapEventHandler(async () => {
    const routes = await discoverDocsRoutes(getGitHubClient())

    return sitemapDocsRoutes(routes) as SitemapUrlInput[]
})
