<template>
    <default-field
        :field="field"
        :errors="errors"
    >
        <template slot="field">
            <div class="px-8 pt-6">
                <resource-gallery
                    v-if="hasSetInitialValue"
                    ref="gallery"
                    v-model="value"
                    :field="field"
                    :multiple="field.multiple"
                    :has-error="hasError"
                    :first-error="firstError"
                    editable
                />

                <button
                    type="button"
                    class="form-file-btn btn btn-default btn-primary mt-2"
                    @click="openMediaGallery"
                >
                    Add Existing File
                </button>

                <media-gallery
                    :collection="field.attribute"
                    :open="mediaGalleryOpen"
                    @close="closeMediaGallery"
                    @select="addItem"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova';
    import MediaGallery from '../MediaGallery';
    import ResourceGallery from '../ResourceGallery';

    export default {
        mixins: [FormField, HandlesValidationErrors],

        components: { MediaGallery, ResourceGallery },

        props: ['resourceName', 'resourceId', 'field'],

        data() {
            return {
                hasSetInitialValue: false,
                mediaGalleryOpen: false,
            };
        },

        methods: {
            /**
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                let value = this.field.value || [];

                if (!this.field.multiple) {
                    value = value.slice(0, 1);
                }

                this.value = value;
                this.hasSetInitialValue = true;
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                const field = this.field.attribute;

                this.value.forEach((file, index) => {
                    const isNewFile = !file.id;

                    if (isNewFile) {
                        formData.append(`__media__[${field}][${index}]`, file.file, file.name);
                    } else {
                        formData.append(`__media__[${field}][${index}]`, file.id);
                    }
                });
            },

            /**
             * Update the field's internal value.
             */
            handleChange(value) {
                this.value = value;
            },

            /**
             * Add an item to the field's internal value
             */
            addItem(item) {
                if (!this.field.multiple) {
                    this.value.splice(0, 1);
                }

                this.value.push(item);
            },

            openMediaGallery() {
                this.mediaGalleryOpen = true;
            },

            closeMediaGallery() {
                this.mediaGalleryOpen = false;
            },
        },
    };
</script>
