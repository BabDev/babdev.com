<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <div
                class="py-3"
                v-html="field.value"
            />
        </template>
    </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
