import { Octokit } from '@octokit/rest'
import tailwindcss from '@tailwindcss/vite'
import { discoverDocsRoutes } from './server/utils/docs'

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

                for (const route of await discoverDocsRoutes(octokit)) {
                    routes.add(route)
                }
            },
        },
    },

    routeRules: {
        '/llms.txt': { prerender: true },
        '/open-source/packages/**': { prerender: true },

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
        // Workaround for nuxt/icon#518: from 2.4.0 the runtime plugin calls
        // `_api.setFetch($fetch.native)` with `useRequestFetch()`, which during SSR is
        // Nitro's `event.$fetch` and carries no `.native`. That leaves Iconify with no
        // fetch at all, so every icon fails to resolve while prerendering. Scanning the
        // source for icon names at build time avoids the fetch path entirely. Every
        // `<Icon>` name in the app is a literal (including the variant icons behind
        // Alert.vue's `:name` binding), so the scan finds them all — keep it that way,
        // or a computed icon name will silently stop resolving.
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
