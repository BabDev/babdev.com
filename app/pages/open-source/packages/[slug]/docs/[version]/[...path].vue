<script setup lang="ts">
import { packages } from '~/data/packages'

const route = useRoute()
const version = route.params.version as string
const docPath = (Array.isArray(route.params.path) ? route.params.path.join('/') : route.params.path || '').trim()
const versionSelectorOpen = ref(false)
const versionSelectorRef = useTemplateRef<HTMLDivElement | null>('version-selector')

const pkg = packages.find(p => p.slug === (route.params.slug as string))

if (!pkg) {
    throw createError({ statusCode: 404, message: 'Package not found' })
}

const pkgVersion = pkg.versions.find(v => v.version === version)

if (!pkgVersion) {
    // If the version param matches the version pattern, 404; otherwise, try to redirect to the latest version and let that 404 if needed
    if (/^\d+\.x$/.test(version)) {
        throw createError({ statusCode: 404, message: 'Version not found' })
    }

    const latestVersion = getLatestStablePackageVersion(pkg)

    if (!latestVersion) {
        throw createError({ statusCode: 404, message: 'No versions available' })
    }

    await navigateTo(
        `/open-source/packages/${pkg.slug}/docs/${latestVersion.version}/${[route.params.version, route.params.path].join('/')}`,
        {
            redirectCode: 302,
        },
    )
}

if (docPath === '') {
    await navigateTo(`/open-source/packages/${pkg.slug}/docs/${pkgVersion!.version}/intro`, {
        redirectCode: 302,
    })
}

// Fetch documentation
const { data: docData, error } = await useFetch(`/api/packages/${pkg.slug}/docs/${pkgVersion!.version}/${docPath}`)

if (error.value) {
    throw createError({
        statusCode: error.value.statusCode || 404,
        message: error.value.message || 'Documentation not found',
    })
}

// Fetch sidebar
const { data: sidebarData } = await useFetch(`/api/packages/${pkg.slug}/docs/${pkgVersion!.version}/index`)

// Extract page title from markdown content
const title = computed(() => {
    if (!docData.value?.content) {
        return pkg.name
    }

    const match = docData.value.content.match(/^#\s+(.+)$/m)

    return match ? match[1] : pkg.name
})

useSeoMeta({
    title: `${title.value} | ${pkg.name} ${pkgVersion!.version} Documentation`,
})

// Close version selector on route change
watch(
    () => route.path,
    () => {
        versionSelectorOpen.value = false
    },
)

// Click outside to close version selector
function handleClickOutside(event: MouseEvent) {
    if (versionSelectorRef.value && !versionSelectorRef.value.contains(event.target as Node)) {
        versionSelectorOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <AppHero>
        <template #title>{{ pkg.name }}</template>
        <template #subtitle>Documentation</template>
    </AppHero>

    <article class="py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <aside class="mb-6 lg:col-span-3 lg:mb-0 xl:col-span-2">
                    <div class="sticky top-24 space-y-6">
                        <div v-if="pkg.versions.length > 1" ref="version-selector" class="relative">
                            <button
                                class="focus:ring-brand-orange flex w-full items-center justify-between rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                                @click="versionSelectorOpen = !versionSelectorOpen"
                            >
                                <span>Version {{ pkgVersion!.version }}</span>
                                <Icon
                                    name="fa7-solid:chevron-down"
                                    :class="[
                                        'h-4 w-4 transform fill-current transition-transform duration-200',
                                        versionSelectorOpen ? 'rotate-180' : '',
                                    ]"
                                />
                            </button>

                            <Transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-show="versionSelectorOpen"
                                    class="ring-opacity-5 absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg ring-1 ring-black focus:outline-none"
                                >
                                    <div class="max-h-60 overflow-auto py-1">
                                        <NuxtLink
                                            v-for="availableVersion in pkg.versions"
                                            :key="availableVersion.version"
                                            :to="`/open-source/packages/${pkg.slug}/docs/${availableVersion.version}/${docPath}`"
                                            :class="[
                                                'block px-4 py-2 text-sm transition-colors duration-200',
                                                availableVersion.version === pkgVersion!.version
                                                    ? 'bg-brand-orange text-white'
                                                    : 'text-gray-700 hover:bg-gray-100',
                                            ]"
                                        >
                                            {{ availableVersion.version }}
                                        </NuxtLink>
                                    </div>
                                </div>
                            </Transition>
                        </div>

                        <nav class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                            <div class="p-4">
                                <MDC class="docs-sidebar-nav" :value="sidebarData?.content ?? ''" tag="div" />
                            </div>
                        </nav>
                    </div>
                </aside>

                <main class="lg:col-span-9 xl:col-span-10">
                    <div v-if="!pkgVersion!.released" class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <Icon name="fa7-solid:info-circle" class="h-5 w-5 fill-current text-blue-400" />
                            </div>
                            <div class="ml-3">
                                <div class="text-xl font-semibold text-blue-800">Version Not Yet Released</div>
                                <p class="text-md mt-1 text-blue-700">
                                    You are viewing the documentation for the {{ pkgVersion!.version }} branch of the
                                    {{ pkg.name }} package which has not yet been released. Be aware that the API for
                                    this version may change before release.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="pkgVersion!.endOfSupport && new Date(pkgVersion!.endOfSupport) < new Date()"
                        class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 p-4"
                    >
                        <div class="flex">
                            <div class="shrink-0">
                                <Icon
                                    name="fa7-solid:exclamation-triangle"
                                    class="h-5 w-5 fill-current text-yellow-400"
                                />
                            </div>
                            <div class="ml-3">
                                <div class="text-xl font-semibold text-yellow-800">Version No Longer Supported</div>
                                <p class="text-md mt-1 text-yellow-700">
                                    You are viewing the documentation for the {{ pkgVersion!.version }} branch of the
                                    {{ pkg.name }} package which is no longer supported as of
                                    <NuxtTime
                                        :datetime="pkgVersion!.endOfSupport"
                                        year="numeric"
                                        month="long"
                                        day="numeric"
                                        locale="en-US"
                                    />. You are advised to upgrade as soon as possible to a supported version.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="p-8">
                            <MDC class="docs-content" :value="docData?.content ?? ''" tag="div" />
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </article>
</template>

<style lang="css">
@reference '~/assets/css/main.css';

@source inline('docs-note');

@layer components {
    .docs-note {
        @apply mb-4 border-l-[5px] border-solid border-l-gray-600 px-2 py-3 text-gray-600 italic;
    }

    .docs-note.docs-note--new-feature {
        @apply border-l-brand-green text-brand-green;
    }

    .docs-note.docs-note--deprecated-feature {
        @apply border-l-brand-orange text-brand-orange;
    }

    .docs-note.docs-note--tip {
        @apply border-l-brand-blue text-brand-blue;
    }

    .not-prose + .docs-note {
        @apply mt-4;
    }
}

@layer utilities {
    .docs-sidebar-nav {
        @apply prose prose-sm prose-gray prose-ul:list-none prose-ul:space-y-1 prose-li:text-sm prose-li:list-none prose-li:pl-0 prose-li:ml-0 prose-a:no-underline prose-a:block prose-a:rounded-md prose-a:transition-colors prose-a:duration-200 prose-a:hover:text-orange-700 prose-a:hover:bg-gray-50 max-w-none;
    }

    .docs-sidebar-nav > ul {
        @apply mt-0 ml-0 pl-0;
    }

    .docs-sidebar-nav > ul > li > a {
        @apply px-3 py-2 text-gray-600;
    }

    .docs-sidebar-nav > ul > li > ul {
        @apply mt-1 ml-0 border-l border-gray-200 pl-4;
    }

    .docs-sidebar-nav > ul > li > ul > li > a {
        @apply px-3 py-1.5 text-gray-500;
    }

    .docs-sidebar-nav .router-link-exact-active {
        @apply bg-brand-orange font-medium text-white hover:bg-orange-600 hover:text-white;
    }

    .docs-content {
        @apply prose prose-headings:text-gray-900 prose-headings:font-semibold prose-h1:text-3xl prose-h1:font-bold prose-h1:mb-6 prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4 prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3 prose-h4:text-lg prose-h4:mt-4 prose-h4:mb-2 prose-h5:text-base prose-h5:mt-4 prose-h5:mb-2 prose-h6:text-sm prose-h6:mt-4 prose-h6:mb-2 prose-p:mb-4 prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-brand-orange prose-a:hover:text-orange-700 prose-ol:mb-4 prose-ol:pl-6 prose-ul:mb-4 prose-ul:pl-6 prose-li:mb-1 prose-blockquote:border-l-4 prose-blockquote:border-brand-orange prose-blockquote:pl-4 prose-blockquote:mb-4 prose-blockquote:italic prose-blockquote:text-gray-600 prose-table:w-full prose-table:border-collapse prose-table:border prose-table:border-gray-300 prose-table:mb-4 prose-th:border prose-th:border-gray-300 prose-th:px-4 prose-th:py-2 prose-th:text-left prose-th:bg-gray-50 prose-th:font-semibold prose-td:border prose-td:border-gray-300 prose-td:px-4 prose-td:py-2 prose-td:text-left max-w-none;
    }

    .docs-content code {
        @apply rounded bg-gray-100 px-1 py-0.5 text-sm text-gray-900;
    }

    .docs-content pre {
        @apply overflow-x-auto rounded-lg border border-gray-200 bg-gray-50 p-4;
    }

    .docs-content pre code {
        @apply bg-transparent px-0 py-0;
    }
}
</style>
