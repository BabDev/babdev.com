<script setup lang="ts">
import { packages } from '~/data/packages'

const route = useRoute()
const packageSlug = route.params.slug as string

// Find package
const pkg = packages.find(p => p.slug === packageSlug)

if (!pkg) {
    throw createError({statusCode: 404, message: 'Package not found'})
}

if (!pkg.hasDocumentation) {
    throw createError({statusCode: 404, message: 'This package does not have documentation'})
}

// Get latest version
const latestVersion = getLatestStablePackageVersion(pkg)

if (!latestVersion) {
    throw createError({statusCode: 404, message: 'No versions available'})
}

// Redirect to latest version docs
navigateTo(`/open-source/packages/${packageSlug}/docs/${latestVersion.version}/intro`, {
    redirectCode: 302,
})
</script>

<template>
    <div>Redirecting to package documentation...</div>
</template>
