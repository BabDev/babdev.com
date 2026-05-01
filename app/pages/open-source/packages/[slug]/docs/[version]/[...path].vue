<script setup lang="ts">
import { packages } from '~/data/packages'

const route = useRoute()
const version = route.params.version as string
const docPath = (Array.isArray(route.params.path) ? route.params.path.join('/') : route.params.path || '')
    .trim()
    .replace(/\/+$/, '')
const versionSelectorOpen = ref(false)
const versionSelectorRef = useTemplateRef<HTMLDivElement | null>('version-selector')

// Legacy slug rename: babdevpagerfantabundle → pagerfantabundle (preserve version + path)
if ((route.params.slug as string) === 'babdevpagerfantabundle') {
    const trailing = docPath ? `/${docPath}` : ''

    await navigateTo(`/open-source/packages/pagerfantabundle/docs/${version}${trailing}`, { redirectCode: 301 })
}

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

const gitHubFileUrl = computed(() => {
    const branch = pkgVersion!.gitBranch || pkgVersion!.version

    return `https://github.com/${pkg.github.owner}/${pkg.github.repo}/edit/${branch}/docs/${docPath}.md`
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
                    <AppAlert v-if="!pkg.supported" variant="danger">
                        <template #title>Package No Longer Supported</template>
                        The {{ pkg.name }} package is no longer supported and will not receive further updates or bug
                        fixes. You are advised to migrate to an alternative solution.
                    </AppAlert>

                    <AppAlert v-if="!pkgVersion!.released" variant="info">
                        <template #title>Version Not Yet Released</template>
                        You are viewing the documentation for the {{ pkgVersion!.version }} branch of the
                        {{ pkg.name }} package which has not yet been released. Be aware that the API for this version
                        may change before release.
                    </AppAlert>

                    <AppAlert
                        v-if="pkgVersion!.endOfSupport && new Date(pkgVersion!.endOfSupport) < new Date()"
                        variant="warning"
                    >
                        <template #title>Version No Longer Supported</template>
                        You are viewing the documentation for the {{ pkgVersion!.version }} branch of the
                        {{ pkg.name }} package which is no longer supported as of
                        <NuxtTime
                            :datetime="pkgVersion!.endOfSupport"
                            year="numeric"
                            month="long"
                            day="numeric"
                            locale="en-US"
                        />. You are advised to upgrade as soon as possible to a supported version.
                    </AppAlert>

                    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="p-8">
                            <MDC class="docs-content" :value="docData?.content ?? ''" tag="div" />
                        </div>
                    </div>

                    <div class="mt-4 text-right text-sm">
                        <a
                            :href="gitHubFileUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="hover:text-brand-orange inline-flex items-center gap-1 text-gray-500 transition-colors duration-200"
                        >
                            <Icon name="fa7-brands:github" class="h-4 w-4 fill-current" />
                            Help improve this page
                        </a>
                    </div>
                </main>
            </div>
        </div>
    </article>
</template>
