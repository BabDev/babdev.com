import tailwindcss from '@tailwindcss/vite'
import discoverDocumentationRoutes from './scripts/discover-routes'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    modules: [
        '@nuxt/eslint',
        '@nuxt/icon',
        '@nuxt/image',
        '@nuxtjs/google-fonts',
        '@nuxtjs/mdc',
        '@nuxtjs/sitemap',
    ],

    site: {
        url: process.env.NUXT_PUBLIC_SITE_URL || 'http://localhost:3000',
        name: 'BabDev',
    },

    compatibilityDate: '2025-07-15',

    devtools: {
        enabled: true,
    },

    vite: {
        plugins: [
            tailwindcss(),
        ],
    },

    css: [
        './app/assets/css/main.css'
    ],

    icon: {
        mode: 'css',
        cssLayer: 'base',
    },

    ssr: true,

    nitro: {
        static: true,
        prerender: {
            crawlLinks: true,
            routes: [
                '/',
                '/open-source/packages',
                '/privacy',
            ],
        },
    },

    hooks: {
        async 'prerender:routes'(ctx) {
            // Discover documentation routes from GitHub at build time
            for (const route of await discoverDocumentationRoutes()) {
                ctx.routes.add(route)
            }
        },
    },

    runtimeConfig: {
        githubToken: process.env.GITHUB_TOKEN || '',
        public: {
            siteUrl: process.env.NUXT_PUBLIC_SITE_URL || 'http://localhost:3000',
        }
    },

    app: {
        head: {
            title: 'BabDev',
            link: [
                {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'},
            ],
        },
    },

    googleFonts: {
        download: true,
        families: {
            'Bree+Serif': true,
            'Droid+Sans': true,
        },
    },

    mdc: {
        components: {
            prose: true,
            map: {
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
        zeroRuntime: true,
    },
})
