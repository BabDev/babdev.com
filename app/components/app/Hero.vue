<script setup lang="ts">
defineSlots<{
    title?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
    subtitle?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
}>()
</script>

<template>
    <section class="relative bg-gradient-to-br from-brand-orange to-orange-600 overflow-hidden">
        <div class="absolute inset-0 bg-black/20" />

        <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-18">
            <div class="text-center">
                <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-4xl"><slot name="title" /></h1>
                <h2 v-if="$slots.subtitle" class="mt-6 text-lg leading-8 text-orange-100 sm:text-xl lg:text-2xl"><slot name="subtitle" /></h2>
            </div>
        </div>
    </section>
</template>
