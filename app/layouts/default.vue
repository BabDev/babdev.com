<script setup lang="ts">
const route = useRoute()
const mobileMenuOpen = ref(false)

// Close mobile menu on route change
watch(
    () => route.path,
    () => {
        mobileMenuOpen.value = false
    },
)

function isActive(routeName: string | string[]): boolean {
    const routes = Array.isArray(routeName) ? routeName : [routeName]

    return routes.some(r => route.path.startsWith(r))
}

useHead({
    bodyAttrs: {
        class: 'min-h-full flex flex-col bg-gray-50',
    }
})
</script>

<template>
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex shrink-0 items-center">
                    <NuxtLink to="/" class="flex">
                        <span class="h-auto w-14">
                            <img src="/logo.svg" alt="BabDev Logo" class="h-full w-full">
                        </span>
                    </NuxtLink>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <NuxtLink
                            to="/open-source/packages"
                            :class="[
                                'px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200',
                                isActive('/open-source/packages')
                                    ? 'text-brand-orange bg-brand-orange/10'
                                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                            ]"
                        >
                            Packages
                        </NuxtLink>
                    </div>
                </div>

                <div class="md:hidden">
                    <button
                        type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                    >
                        <span class="sr-only">Open main menu</span>
                        <Icon name="fa7-solid:bars" class="h-6 w-6 fill-current" />
                    </button>
                </div>
            </div>

            <div v-if="mobileMenuOpen" class="md:hidden">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <NuxtLink
                        to="/open-source/packages"
                        :class="[
                            'block rounded-md px-3 py-2 text-base font-medium transition-colors duration-200',
                            isActive('/open-source/packages')
                                ? 'text-brand-orange bg-brand-orange/10'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                        ]"
                    >
                        Packages
                    </NuxtLink>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        <slot />
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                <nav class="flex flex-wrap items-center space-x-6">
                    <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="https://github.com/BabDev" rel="nofollow noopener">GitHub</a>
                    <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="https://packagist.org/packages/babdev" rel="nofollow noopener">Packagist</a>
                    <NuxtLink to="/privacy" class="text-gray-600 hover:text-brand-orange transition-colors duration-200">Privacy</NuxtLink>
                </nav>
                <div class="text-sm text-gray-500">
                    All rights reserved. © 2010 - {{ new Date().getFullYear() }} <NuxtLink to="/" class="text-brand-orange hover:text-orange-700 transition-colors duration-200">BabDev</NuxtLink>.
                </div>
            </div>
        </div>
    </footer>
</template>
