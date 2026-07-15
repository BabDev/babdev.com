<script setup lang="ts">
import type { NuxtError } from '#app'

const props = defineProps<{
    error: NuxtError
}>()

// `status` may be undefined for client-side errors; fall back to a generic 500.
const status = computed(() => props.error.status ?? 500)

const isNotFound = computed(() => status.value === 404)

const title = computed(() => (isNotFound.value ? 'Page Not Found' : 'Something Went Wrong'))

const subtitle = computed(() =>
    isNotFound.value
        ? "The page you're looking for doesn't exist or may have moved."
        : 'An unexpected error occurred while loading this page.',
)

useHead({
    bodyAttrs: {
        class: 'min-h-full flex flex-col bg-gray-50',
    },
})

useSeoMeta({
    title: () => `${status.value} - ${title.value}`,
})

// clearError unmounts the error page and navigates, ensuring app state is reset.
const goHome = () => clearError({ redirect: '/' })
const goToPackages = () => clearError({ redirect: '/open-source/packages' })
</script>

<template>
    <AppHeader />

    <main class="flex-1">
        <AppHero>
            <template #title>{{ status }} — {{ title }}</template>
            <template #subtitle>{{ subtitle }}</template>
        </AppHero>

        <section class="py-16 sm:py-24">
            <div class="mx-auto max-w-2xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-lg text-gray-600">
                    Let's get you back on track. Head to the home page or browse the open-source packages.
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <button
                        type="button"
                        class="bg-brand-orange rounded-md px-6 py-3 text-base font-medium text-white transition-colors duration-200 hover:bg-orange-700"
                        @click="goHome"
                    >
                        Back to Home
                    </button>
                    <button
                        type="button"
                        class="border-brand-orange text-brand-orange hover:bg-brand-orange/10 rounded-md border px-6 py-3 text-base font-medium transition-colors duration-200"
                        @click="goToPackages"
                    >
                        Browse Packages
                    </button>
                </div>
            </div>
        </section>
    </main>

    <AppFooter />
</template>
