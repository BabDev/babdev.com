<script setup lang="ts">
defineProps<{ id?: string }>()

defineSlots<{
    default?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
}>()
</script>

<template>
    <h6>
        <a
            v-if="id"
            :id="id"
            :href="`#${id}`"
            class="anchor"
            aria-hidden="true"
        />
        <slot />
    </h6>
</template>
