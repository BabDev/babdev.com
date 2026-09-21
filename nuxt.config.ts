import { Octokit } from '@octokit/rest'
import tailwindcss from '@tailwindcss/vite'
import { discoverDocsRoutes, docsIndexRoutes, slugRenameRoutes, toRawDocsRoute } from './server/utils/docs'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    modules: ['@nuxt/eslint', '@nuxt/fonts', '@nuxt/icon', '@nuxt/image', '@comark/nuxt', '@nuxtjs/sitemap', 'reka-ui/nuxt'],

    compatibilityDate: '2025-07-15',

    devtools: {
        enabled: true,
    },

    vite: {
        plugins: [tailwindcss()],
    },

    css: ['~/assets/css/main.css'],

    ssr: true,

    nitro: {
        static: true,
        prerender: {
            autoSubfolderIndex: false,
            crawlLinks: true,
        },
        hooks: {
            async 'prerender:routes'(routes) {
                const octokit = new Octokit({ auth: process.env.GITHUB_TOKEN })
                const docsRoutes = await discoverDocsRoutes(octokit)

                for (const route of docsRoutes) {
                    routes.add(route)

                    // Every documentation page is published twice: the HTML page and its raw Markdown twin
                    // under `/raw`. The twins are enumerated here rather than discovered by `crawlLinks`
                    // because they are only ever referenced from a `<link rel="alternate">`, which the
                    // prerenderer's crawler does not follow.
                    const rawRoute = toRawDocsRoute(route)

                    if (rawRoute) {
                        routes.add(rawRoute)
                    }
                }

                // Redirects only exist on GitHub Pages where a file was written for them, so the routes a
                // package redirects *from* have to be enumerated too — the `/docs` index of every package,
                // and every documentation URL a renamed package used to serve. The `/raw` twins are
                // deliberately left out of the rename set: GitHub Pages types a `.md` file as
                // `text/markdown`, so a redirect file there would hand an agent an HTML document under a
                // Markdown content type, which is worse than the 404 it gets instead.
                for (const route of [...docsIndexRoutes(), ...slugRenameRoutes(docsRoutes)]) {
                    routes.add(route)
                }
            },
        },
    },

    routeRules: {
        '/llms.txt': { prerender: true },
        '/open-source/packages/**': { prerender: true },
        '/raw/**': { prerender: true },

        // Legacy URL redirect
        '/index.php': { redirect: { to: '/', statusCode: 301 } },
        '/open-source/updates': { redirect: { to: '/', statusCode: 301 } },
        '/open-source/updates/**': { redirect: { to: '/', statusCode: 301 } },
        '/extensions': { redirect: { to: '/open-source/packages', statusCode: 301 } },
        '/extensions/**': { redirect: { to: '/open-source/packages', statusCode: 301 } },
    },

    site: {
        url: process.env.NUXT_PUBLIC_SITE_URL || 'http://localhost:3000',
        name: 'BabDev',
    },

    runtimeConfig: {
        githubToken: process.env.GITHUB_TOKEN || '',
        public: {
            siteUrl: process.env.NUXT_PUBLIC_SITE_URL || 'http://localhost:3000',
        },
    },

    app: {
        head: {
            title: 'BabDev',
            link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
        },
    },

    fonts: {
        families: [
            { name: 'BPScript', provider: 'local' },
            { name: 'Bree Serif', provider: 'google' },
            { name: 'Open Sans', provider: 'google' },
        ],
        providers: {
            adobe: false,
            bunny: false,
            fontshare: false,
            fontsource: false,
            googleicons: false,
            npm: false,
        },
    },

    icon: {
        mode: 'css',
        cssLayer: 'base',
        // The site is fully prerendered and ships no `/api/_nuxt_icon` endpoint, so
        // nothing serves icons once the page is live. Scanning the source at build time
        // bundles every icon the app uses (16, ~7.7KB) into the client, which keeps
        // post-hydration rendering off the public Iconify API. Every `<Icon>` name is a
        // literal (including the variant icons behind Alert.vue's `:name` binding), so
        // the scan finds them all — keep it that way, or a computed name drops out of
        // the bundle and silently resolves over the network instead.
        clientBundle: {
            scan: true,
        },
    },

    sitemap: {
        sources: ['/api/__sitemap__/docs'],
        urls: ['/llms.txt'],
        zeroRuntime: true,
    },
})
