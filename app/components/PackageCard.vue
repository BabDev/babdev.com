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
                        <h2 class="text-xl font-semibold text-gray-900">{{ pkg.name }}</h2>
                        <a
                            class="text-gray-400 transition-colors duration-200 hover:text-gray-600"
                            :href="`https://github.com/${pkg.github.owner}/${pkg.github.repo}`"
                            target="_blank"
                            rel="nofollow noreferrer noopener"
                            :aria-label="`View ${pkg.name} on GitHub`"
                        >
                            <Icon name="fa7-brands:github" class="block h-5 w-5 fill-current" />
                        </a>
                    </div>

                    <p v-if="pkg.description" class="mt-2 leading-relaxed text-gray-600">{{ pkg.description }}</p>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span v-if="!pkg.supported" class="package-statistic package-statistic--unsupported">
                    Package Not Supported
                </span>
                <span class="package-statistic package-statistic--language">{{ pkg.language }}</span>
                <span
                    :class="`package-statistic package-statistic--package-type package-statistic--package-type--${pkg.packageType}`"
                >
                    {{ getPackageTypeLabel(pkg.packageType) }}
                </span>
                <span v-if="pkg.downloads" class="package-statistic package-statistic--downloads">
                    {{ pkg.downloads.toLocaleString('en-US') }}
                    <Icon name="fa7-solid:download" class="ml-1 h-3 w-3 fill-current" />
                </span>
                <span v-if="pkg.stars" class="package-statistic package-statistic--stars">
                    {{ pkg.stars.toLocaleString('en-US') }}
                    <Icon name="fa7-regular:star" class="ml-1 h-3 w-3 fill-current" />
                </span>
            </div>

            <div v-if="pkg.topics.length" class="mt-4 flex flex-wrap gap-1">
                <span
                    v-for="topic in pkg.topics"
                    :key="`${pkg.slug}-topic-${topic}`"
                    class="mr-1 mb-1 inline-block rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800"
                >
                    {{ topic }}
                </span>
            </div>

            <div v-if="pkg.hasDocumentation" class="mt-6 flex items-center justify-between">
                <div class="flex space-x-3">
                    <NuxtLink
                        class="bg-brand-orange focus:ring-brand-orange inline-flex items-center rounded-md px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-orange-600 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                        :to="`/open-source/packages/${pkg.slug}/docs/${getLatestStablePackageVersion(pkg)!.version}/intro`"
                    >
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
        @apply mr-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800;
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
