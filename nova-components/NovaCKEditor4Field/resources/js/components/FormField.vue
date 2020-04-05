<template>
    <default-field
        :field="field"
        :errors="errors"
        full-width-content>
        <template slot="field">
            <ckeditor
                v-model="value"
                :config="config"
                :editorUrl="editorUrl"
            />
        </template>
    </default-field>
</template>

<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova';

    export default {
        mixins: [ FormField, HandlesValidationErrors ],

        props: ['resourceName', 'resourceId', 'field'],

        data() {
            return {
                config: this.field.editorConfig,
                editorDistribution: this.field.editorDistribution,
                editorVersion: this.field.editorVersion,
            };
        },

        computed: {
            editorUrl() {
                return `https://cdn.ckeditor.com/${this.editorVersion}/${this.editorDistribution}/ckeditor.js`;
            },
        },

        methods: {
            /**
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || '';
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                formData.append(this.field.attribute, this.value || '');
            },

            /**
             * Update the field's internal value.
             */
            handleChange(value) {
                this.value = value;
            },
        },
    }
</script>
