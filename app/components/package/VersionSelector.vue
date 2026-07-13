<script setup lang="ts">
const props = defineProps<{
    versions: PackageVersion[]
    currentVersion: string
    slug: string
    docPath: string
}>()

function versionPath(version: string): string {
    return `/open-source/packages/${props.slug}/docs/${version}/${props.docPath}`
}
</script>

<template>
    <DropdownMenuRoot>
        <DropdownMenuTrigger
            class="group focus:ring-brand-orange flex w-full items-center justify-between rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none"
        >
            <span>Version {{ currentVersion }}</span>
            <Icon
                name="fa7-solid:chevron-down"
                class="h-4 w-4 transform fill-current transition-transform duration-200 group-data-[state=open]:rotate-180"
            />
        </DropdownMenuTrigger>

        <DropdownMenuPortal>
            <DropdownMenuContent
                :side-offset="4"
                align="start"
                class="ring-opacity-5 z-50 max-h-60 w-[var(--reka-dropdown-menu-trigger-width)] overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black focus:outline-none data-[state=closed]:animate-[reka-menu-out_75ms_ease-in] data-[state=open]:animate-[reka-menu-in_100ms_ease-out]"
            >
                <DropdownMenuItem v-for="availableVersion in versions" :key="availableVersion.version" as-child>
                    <NuxtLink
                        :to="versionPath(availableVersion.version)"
                        :class="[
                            'block cursor-pointer px-4 py-2 text-sm transition-colors duration-200 outline-none',
                            availableVersion.version === currentVersion
                                ? 'bg-brand-orange text-white'
                                : 'text-gray-700 data-highlighted:bg-gray-100',
                        ]"
                    >
                        {{ availableVersion.version }}
                    </NuxtLink>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenuPortal>
    </DropdownMenuRoot>
</template>
