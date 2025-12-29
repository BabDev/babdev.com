<script setup lang="ts">
defineProps<{
    pkg: EnrichedPackage
}>()
</script>

<template>
    <article
        :class="[
            'mb-8 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 transition-shadow duration-200 hover:shadow-md',
            !pkg.supported ? 'opacity-75' : '',
        ]"
    >
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3">
                        <h2 class="text-xl font-semibold text-gray-900">{{ pkg.displayName }}</h2>
                        <a class="text-gray-400 hover:text-gray-600 transition-colors duration-200" :href="pkg.githubUrl" target="_blank" rel="nofollow noreferrer noopener" :aria-label="`View ${pkg.displayName} on GitHub`">
                            <Icon name="fa7-brands:github" class="h-5 w-5 block fill-current" />
                        </a>
                    </div>

                    <p class="mt-2 text-gray-600 leading-relaxed">{{ pkg.description }}</p>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span v-if="!pkg.supported" class="package-statistic package-statistic--unsupported">Package Not Supported</span>
                <span class="package-statistic package-statistic--language">{{ pkg.language }}</span>
                <span v-if="pkg.packageType" :class="`package-statistic package-statistic--package-type package-statistic--package-type--${pkg.packageType}`">{{ getPackageTypeLabel(pkg.packageType) }}</span>
                <span v-if="pkg.downloads" class="package-statistic package-statistic--downloads">
                    {{ pkg.downloads.toLocaleString('en-US') }} <Icon name="fa7-solid:download" class="ml-1 h-3 w-3 fill-current" />
                </span>
                <span v-if="pkg.stars" class="package-statistic package-statistic--stars">
                    {{ pkg.stars.toLocaleString('en-US') }} <Icon name="fa7-regular:star" class="ml-1 h-3 w-3 fill-current" />
                </span>
            </div>

            <div v-if="pkg.topics.length" class="mt-4 flex flex-wrap gap-1">
                <span v-for="topic in pkg.topics" :key="`${pkg.slug}-topic-${topic}`" class="inline-block px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full mr-1 mb-1">{{ topic }}</span>
            </div>

            <div v-if="pkg.hasDocumentation" class="mt-6 flex items-center justify-between">
                <div class="flex space-x-3">
                    <NuxtLink class="inline-flex items-center rounded-md bg-brand-orange px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition-colors duration-200" :to="`/open-source/packages/${pkg.slug}/docs/${getLatestStablePackageVersion(pkg)!.version}/intro`">
                        View Documentation <Icon name="fa7-regular:file-lines" class="ml-2 h-4 w-4 fill-current" />
                    </NuxtLink>
                </div>
            </div>
        </div>
    </article>
</template>

<style lang="css">
@reference '~/assets/css/main.css';

@layer components {
    .package-statistic {
        @apply inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full mr-2;
    }

    .package-statistic.package-statistic--unsupported {
        @apply bg-red-100 text-red-800;
    }

    .package-statistic.package-statistic--language {
        @apply bg-blue-100 text-blue-800;
    }

    .package-statistic.package-statistic--package-type--symfony-bundle {
        @apply bg-green-100 text-green-800;
    }

    .package-statistic.package-statistic--package-type--laravel-package {
        @apply bg-red-100 text-red-800;
    }

    .package-statistic.package-statistic--downloads,
    .package-statistic.package-statistic--stars {
        @apply bg-yellow-100 text-yellow-800;
    }
}
</style>
