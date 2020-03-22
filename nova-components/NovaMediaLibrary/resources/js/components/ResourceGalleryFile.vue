<template>
    <div
        class="flex flex-col justify-center float-left w-full relative rounded-lg bg-primary-30% mb-3 p-3"
        :class="{'cursor-grab': draggable}"
    >
        <div class="flex z-10">
            <a
                v-if="downloadUrl"
                class="text-primary-dark mr-2"
                :href="downloadUrl"
            >
                <icon
                    type="download"
                    view-box="0 0 20 22"
                    width="16"
                    height="16"
                />
            </a>

            <span class="flex-grow">
                {{ file.file_name }}
            </span>

            <a
                v-if="removable"
                class="self-end text-danger ml-2"
                href="#"
                @click.prevent="removeFile"
            >
                <icon
                    type="delete"
                    view-box="0 0 20 20"
                    width="16"
                    height="16"
                />
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            draggable: {
                type: Boolean,
                default: false,
            },

            file: {
                type: Object,
                required: true,
            },

            removable: {
                type: Boolean,
                default: false,
            },
        },

        computed: {
            downloadUrl() {
                if (!this.file.id) {
                    return null;
                }

                return `/nova-vendor/babdev/nova-media-library/download/${this.file.id}`;
            },
        },

        methods: {
            removeFile() {
                this.$emit('remove');
            },
        },
    };
</script>

<style lang="scss">
    .cursor-grab {
        cursor: grab;
    }
</style>
