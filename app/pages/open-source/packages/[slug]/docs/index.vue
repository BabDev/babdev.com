<script setup lang="ts">
import { packages } from '~/data/packages'

const route = useRoute()
const packageSlug = route.params.slug as string

// Find package, accepting any slug it has ever been published under
const pkg = packages.find(p => p.slug === packageSlug || p.previousSlugs?.includes(packageSlug))

if (!pkg) {
    throw createError({ statusCode: 404, message: 'Package not found' })
}

if (!pkg.hasDocumentation) {
    throw createError({ statusCode: 404, message: 'This package does not have documentation' })
}

// Get latest version
const latestVersion = getLatestStablePackageVersion(pkg)

if (!latestVersion) {
    throw createError({ statusCode: 404, message: 'No versions available' })
}

// Redirect to latest version docs. This stays a 302 even when the request came in on a slug the package
// has been renamed away from. Half of such a move is permanent and half is not — the slug will not change
// back, but the version in the target moves with every release — and one hop cannot say both. The page
// routes under this one carry the 301 for the rename, so nothing is lost by keeping this hop temporary.
navigateTo(`/open-source/packages/${pkg.slug}/docs/${latestVersion.version}/intro`, {
    redirectCode: 302,
})
</script>

<template>
    <div>Redirecting to package documentation...</div>
</template>
