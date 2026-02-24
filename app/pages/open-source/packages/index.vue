<script setup lang="ts">
const { data: packages } = await useFetch('/api/packages')

const supportedPackages = computed(() => packages.value?.filter(pkg => pkg.supported) ?? [])
const unsupportedPackages = computed(() => packages.value?.filter(pkg => !pkg.supported) ?? [])

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
            <div v-if="supportedPackages.length">
                <PackageCard v-for="pkg in supportedPackages" :key="pkg.slug" :pkg="pkg" />
            </div>

            <div v-if="unsupportedPackages.length" class="mt-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">No Longer Supported</h2>
                <PackageCard v-for="pkg in unsupportedPackages" :key="pkg.slug" :pkg="pkg" />
            </div>
        </div>
    </section>
</template>
