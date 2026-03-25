<script setup lang="ts">
const props = defineProps<{
    variant: AlertVariant
}>()

defineSlots<{
    default: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
    title?: (props: Record<string, never>) => any // eslint-disable-line @typescript-eslint/no-explicit-any
}>()

// eslint-disable-next-line vue/return-in-computed-property -- All variant values are covered
const variantConfig = computed(() => {
    switch (props.variant) {
        case 'danger':
            return {
                icon: 'fa7-solid:circle-xmark',
                container: 'border-red-200 bg-red-50',
                iconColor: 'text-red-400',
                title: 'text-red-800',
                body: 'text-red-700',
            }
        case 'info':
            return {
                icon: 'fa7-solid:info-circle',
                container: 'border-blue-200 bg-blue-50',
                iconColor: 'text-blue-400',
                title: 'text-blue-800',
                body: 'text-blue-700',
            }
        case 'warning':
            return {
                icon: 'fa7-solid:exclamation-triangle',
                container: 'border-yellow-200 bg-yellow-50',
                iconColor: 'text-yellow-400',
                title: 'text-yellow-800',
                body: 'text-yellow-700',
            }
    }
})
</script>

<template>
    <div :class="['mb-6 rounded-lg border p-4', variantConfig.container]">
        <div class="flex">
            <div class="shrink-0">
                <Icon :name="variantConfig.icon" :class="['h-5 w-5 fill-current', variantConfig.iconColor]" />
            </div>
            <div class="ml-3">
                <div :class="['text-xl font-semibold', variantConfig.title]">
                    <slot name="title" />
                </div>
                <p :class="['text-md mt-1', variantConfig.body]">
                    <slot />
                </p>
            </div>
        </div>
    </div>
</template>
