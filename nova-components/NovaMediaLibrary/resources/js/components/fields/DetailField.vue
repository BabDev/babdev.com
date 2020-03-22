<template>
    <panel-item :field="field">
        <resource-gallery
            slot="value"
            :value="field.value"
            :field="field"
            :multiple="field.multiple"
        />
    </panel-item>
</template>

<script>
    import ResourceGallery from '../ResourceGallery';

    export default {
        components: { ResourceGallery },

        props: ['resource', 'resourceName', 'resourceId', 'field'],
    }
</script>
