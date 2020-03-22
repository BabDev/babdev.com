<template>
    <div>
        <component
            v-if="files.length > 0"
            v-model="files"
            :is="draggable ? 'draggable' : 'div'"
        >
            <resource-gallery-file
                v-for="(file, index) in files"
                :key="index"
                :file="file"
                :draggable="draggable"
                :removable="editable"
                @remove="removeFile(index)"
            />
        </component>

        <span v-if="editable" class="form-file">
            <input
                ref="file"
                class="form-file-input select-none"
                type="file"
                :id="`__media__${field.attribute}`"
                :multiple="multiple"
                @change="addFile"
            />

            <label
                class="form-file-btn btn btn-default btn-primary select-none"
                :for="`__media__${field.attribute}`"
                v-text="uploadLabel"
            />
        </span>

        <p
            v-if="hasError"
            class="my-2 text-danger"
        >
            {{ firstError }}
        </p>
    </div>
</template>

<script>
    import Draggable from 'vuedraggable';
    import ResourceGalleryFile from './ResourceGalleryFile';

    export default {
        components: { Draggable, ResourceGalleryFile },

        props: {
            hasError: {
                type: Boolean,
                default: false,
            },
            firstError: {
                type: String,
                default: null,
            },
            field: {
                type: Object,
                required: true,
            },
            value: {
                type: Array,
                required: true,
            },
            editable: {
                type: Boolean,
                default: false,
            },
            multiple: {
                type: Boolean,
                default: false,
            },
            customProperties: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                files: this.value,
            };
        },

        computed: {
            draggable() {
                return this.editable && this.multiple;
            },

            uploadLabel() {
                if (this.multiple || this.files.length === 0) {
                    return 'Add New File';
                }

                return 'Upload New File';
            },
        },

        watch: {
            value(value) {
                this.files = value;
            },
        },

        methods: {
            addFile() {
                Array.from(this.$refs.file.files).forEach((file) => {
                    file = new File([file], file.name, {type: file.type});

                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        const fileData = {
                            file: file,
                            __media_urls__: {
                                __original__: reader.result,
                            },
                            name: file.name,
                            file_name: file.name,
                        };

                        if (this.multiple) {
                            this.files.push(fileData);
                        } else {
                            this.files = [fileData];
                        }
                    };
                });

                this.$refs.file.value = null;
            },

            removeFile(index) {
                this.files = this.files.filter((value, i) => i !== index);
            },
        },
    };
</script>
