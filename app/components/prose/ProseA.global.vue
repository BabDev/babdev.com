<script setup lang="ts">
defineProps<{ href?: string }>()

defineSlots<{
    default?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
}>()
</script>

<template>
    <NuxtLink :to="href">
        <slot />
    </NuxtLink>
</template>
