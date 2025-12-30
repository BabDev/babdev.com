<script setup lang="ts">
const config = useRuntimeConfig()

useSeoMeta({
    titleTemplate: titleChunk => (titleChunk ? `${titleChunk} | BabDev` : 'BabDev'),
    ogType: 'website',
    ogTitle: 'BabDev',
    ogImage: `${config.public.siteUrl}/images/social-media.webp`,
    ogLocale: 'en_US',
})
</script>

<template>
    <NuxtLayout>
        <NuxtPage />
    </NuxtLayout>
</template>
