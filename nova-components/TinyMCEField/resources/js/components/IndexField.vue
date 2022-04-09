<template>
    <div
        class="py-3"
        v-html="field.value"
    />
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
