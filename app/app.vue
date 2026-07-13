<script setup lang="ts">
const config = useRuntimeConfig()

useHead({
    bodyAttrs: {
        class: 'min-h-full flex flex-col bg-gray-50',
    },
})

useSeoMeta({
    titleTemplate: titleChunk => (titleChunk ? `${titleChunk} | BabDev` : 'BabDev'),
    ogType: 'website',
    ogTitle: 'BabDev',
    ogImage: `${config.public.siteUrl}/images/social-media.webp`,
    ogLocale: 'en_US',
})
</script>

<template>
    <AppHeader />

    <main class="flex-1">
        <NuxtPage />
    </main>

    <footer class="mt-auto border-t border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                <nav class="flex flex-wrap items-center space-x-6">
                    <a
                        class="hover:text-brand-orange text-gray-600 transition-colors duration-200"
                        href="https://github.com/BabDev"
                        rel="nofollow noopener"
                    >
                        GitHub
                    </a>
                    <a
                        class="hover:text-brand-orange text-gray-600 transition-colors duration-200"
                        href="https://packagist.org/packages/babdev"
                        rel="nofollow noopener"
                    >
                        Packagist
                    </a>
                    <NuxtLink
                        to="/privacy"
                        class="hover:text-brand-orange text-gray-600 transition-colors duration-200"
                    >
                        Privacy
                    </NuxtLink>
                </nav>
                <div class="text-sm text-gray-500">
                    All rights reserved. © 2010 - {{ new Date().getFullYear() }}
                    <NuxtLink to="/" class="text-brand-orange transition-colors duration-200 hover:text-orange-700"
                        >BabDev</NuxtLink
                    >.
                </div>
            </div>
        </div>
    </footer>
</template>
