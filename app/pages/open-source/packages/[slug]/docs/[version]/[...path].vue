<script setup lang="ts">
import bash from '@shikijs/langs/bash'
import blade from '@shikijs/langs/blade'
import css from '@shikijs/langs/css'
import html from '@shikijs/langs/html'
import javascript from '@shikijs/langs/javascript'
import json from '@shikijs/langs/json'
import markdown from '@shikijs/langs/markdown'
import php from '@shikijs/langs/php'
import properties from '@shikijs/langs/properties'
import twig from '@shikijs/langs/twig'
import xml from '@shikijs/langs/xml'
import yaml from '@shikijs/langs/yaml'
import githubLight from '@shikijs/themes/github-light'
import highlight from 'comark/plugins/highlight'
import { packages } from '~/data/packages'

const comarkPlugins = [
    highlight({
        themes: { light: githubLight, dark: githubLight },
        languages: [bash, blade, css, html, javascript, json, markdown, php, properties, twig, xml, yaml],
    }),
]

const route = useRoute()
const version = route.params.version as string
const docPath = (Array.isArray(route.params.path) ? route.params.path.join('/') : route.params.path || '')
    .trim()
    .replace(/\/+$/, '')

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
                        <PackageVersionSelector
                            v-if="pkg.versions.length > 1"
                            :versions="pkg.versions"
                            :current-version="pkgVersion!.version"
                            :slug="pkg.slug"
                            :doc-path="docPath"
                        />

                        <nav class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                            <div class="p-4">
                                <Comark
                                    class="docs-sidebar-nav"
                                    :markdown="sidebarData?.content ?? ''"
                                    :plugins="comarkPlugins"
                                />
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
                            <Comark class="docs-content" :markdown="docData?.content ?? ''" :plugins="comarkPlugins" />
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
