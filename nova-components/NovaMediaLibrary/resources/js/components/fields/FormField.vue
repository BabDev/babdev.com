<template>
    <default-field
        :field="field"
        :errors="errors"
    >
        <template slot="field">
            <div class="px-8 pt-6">
                <!-- <gallery
                    v-if="hasSetInitialValue"
                    slot="value"
                    ref="gallery"
                    v-model="value"
                    :field="field"
                    :multiple="field.multiple"
                    :has-error="hasError"
                    :first-error="firstError"
                    editable
                    custom-properties
                /> -->

                <div>
                    <button
                        type="button"
                        class="form-file-btn btn btn-default btn-primary mt-2"
                        @click="mediaGalleryOpen = true"
                    >
                        Add Media
                    </button>

                    <portal to="modals">
                        <media-gallery
                            v-if="mediaGalleryOpen"
                            :open="mediaGalleryOpen"
                            @close="mediaGalleryOpen = false"
                            @select="addItem"
                        />
                    </portal>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova';
    import MediaGallery from '../MediaGallery';

    export default {
        mixins: [FormField, HandlesValidationErrors],

        components: { MediaGallery },

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
        },
    };
</script>
