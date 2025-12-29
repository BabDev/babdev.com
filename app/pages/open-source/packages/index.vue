<script setup lang="ts">
const {data: packages} = await useFetch('/api/packages')

useSeoMeta({
    title: 'Open Source Packages',
})
</script>

<template>
    <AppHero>
        <template #title>Open Source Packages</template>
    </AppHero>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <PackageCard
                v-for="pkg in packages"
                :key="pkg.slug"
                :pkg="pkg"
            />
        </div>
    </section>
</template>
