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
</script>

<template>
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <CollapsibleRoot v-model:open="mobileMenuOpen" as="nav" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex shrink-0 items-center">
                    <NuxtLink to="/" class="flex">
                        <span class="h-auto w-14">
                            <img src="/images/logo.svg" alt="BabDev Logo" class="h-full w-full" />
                        </span>
                    </NuxtLink>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <NuxtLink
                            to="/open-source/packages"
                            :class="[
                                'rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200',
                                isActive('/open-source/packages')
                                    ? 'text-brand-orange bg-brand-orange/10'
                                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                            ]"
                        >
                            Packages
                        </NuxtLink>
                    </div>
                </div>

                <div class="md:hidden">
                    <CollapsibleTrigger
                        class="focus:ring-brand-orange relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                    >
                        <span class="sr-only">Open main menu</span>
                        <Icon
                            :name="mobileMenuOpen ? 'fa7-solid:xmark' : 'fa7-solid:bars'"
                            class="h-6 w-6 fill-current"
                        />
                    </CollapsibleTrigger>
                </div>
            </div>

            <CollapsibleContent
                class="overflow-hidden data-[state=closed]:animate-[reka-collapsible-up_150ms_ease-in] data-[state=open]:animate-[reka-collapsible-down_150ms_ease-out] md:hidden"
            >
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <NuxtLink
                        to="/open-source/packages"
                        :class="[
                            'block rounded-md px-3 py-2 text-base font-medium transition-colors duration-200',
                            isActive('/open-source/packages')
                                ? 'text-brand-orange bg-brand-orange/10'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                        ]"
                    >
                        Packages
                    </NuxtLink>
                </div>
            </CollapsibleContent>
        </CollapsibleRoot>
    </header>
</template>
