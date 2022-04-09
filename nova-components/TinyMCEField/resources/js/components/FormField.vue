<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :full-width-content="true"
        :show-help-text="showHelpText"
    >
        <template #field>
            <Editor
                v-model="value"
                :class="{ 'form-input-border-error': hasError }"
                :api-key="apiKey"
                cloud-channel="6"
                :disabled="isReadonly"
                :id="field.id"
                :init="editorConfigInit"
                :initial-value="field.value || ' '"
                :name="field.name"
                :plugins="editorPlugins"
                :toolbar="editorToolbar"
                v-bind="extraAttributes"
            />
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova';
import Editor from '@tinymce/tinymce-vue';

export default {
    emits: ['field-changed'],

    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        Editor
    },

    data: function () {
        return {
            editorConfigInit: this.field.options.init,
            editorPlugins: this.field.options.plugins,
            editorToolbar: this.field.options.toolbar,
            apiKey: this.field.options.apiKey,
        };
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
    },

    computed: {
        defaultAttributes() {
            return {
                placeholder: this.field.placeholder || this.field.name,
            };
        },

        extraAttributes() {
            return {
                ...this.defaultAttributes,
                ...this.field.extraAttributes,
            };
        },
    },
}
</script>
