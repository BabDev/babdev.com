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

    <AppFooter />
</template>
