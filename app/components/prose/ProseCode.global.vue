<script setup lang="ts">
defineSlots<{
    default?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
}>()
</script>

<template>
    <code class="not-prose"><slot /></code>
</template>
