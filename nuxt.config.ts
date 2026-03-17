import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    modules: ['@nuxt/eslint', '@nuxt/fonts', '@nuxt/icon', '@nuxt/image', '@nuxtjs/mdc', '@nuxtjs/sitemap'],

    compatibilityDate: '2025-07-15',

    devtools: {
        enabled: true,
    },

    vite: {
        plugins: [tailwindcss()],
    },

    css: ['./app/assets/css/main.css'],

    ssr: true,

    nitro: {
        static: true,
        prerender: {
            autoSubfolderIndex: false,
            crawlLinks: true,
        },
    },

    routeRules: {
        '/llms.txt': { prerender: true },
        '/open-source/packages/**': { prerender: true },
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
    },

    mdc: {
        components: {
            prose: true,
            map: {
                code: 'ProseCode',
                h2: 'ProseH2',
                h3: 'ProseH3',
                h4: 'ProseH4',
                h5: 'ProseH5',
                h6: 'ProseH6',
                pre: 'ProsePre',
            },
        },
        highlight: {
            theme: 'github-light',
            langs: [
                'bash',
                'blade',
                'css',
                'javascript',
                'js',
                'json',
                'markdown',
                'md',
                'php',
                'properties',
                'twig',
                'xml',
                'html',
                'yaml',
                'yml',
            ],
        },
    },

    sitemap: {
        sources: ['/api/__sitemap__/docs'],
        urls: ['/llms.txt'],
        zeroRuntime: true,
    },
})
