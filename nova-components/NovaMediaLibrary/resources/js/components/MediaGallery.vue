<template>
    <div
        class="modal select-none fixed pin z-50 overflow-x-hidden overflow-y-auto"
        :class="{'hidden': !open}"
    >
        <div class="h-full w-4/5 mx-auto justify-center">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-8 mt-6">
                <div class="border-b border-40 pb-4 mb-4">
                    <div class="flex items-center">
                        <div class="self-center">
                            <heading :level="3">
                                Media Gallery
                            </heading>
                        </div>

                        <div class="self-center ml-auto">
                            <button
                                type="button"
                                class="btn btn-default btn-primary"
                                @click="handleClose"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex-grow overflow-x-hidden overflow-y-scroll">
                    <loading-view :loading="loading">
                        <div
                            v-if="items.length > 0"
                            class="flex flex-wrap -mx-4 -mb-8"
                        >
                            <template v-for="(item, key) in items">
                                <media-gallery-item
                                    :item="item"
                                    :key="key"
                                    @select="galleryItemSelected"
                                />
                            </template>
                        </div>

                        <heading
                            v-else
                            :level="4"
                        >
                            No files uploaded
                        </heading>
                    </loading-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            collection: {
                type: String,
                required: true,
            },

            open: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                items: [],
                loading: false,
                modalBg: null,
                requestParams: {
                    collection: this.collection,
                    page: 1,
                    per_page: 18,
                },
            };
        },

        watch: {
            open(isOpen) {
                console.log('open flag changed', isOpen);
                if (isOpen) {
                    if (this.items.length === 0) {
                        this.refresh();
                    }

                    document.addEventListener('keydown', this.handleEscape);
                    document.body.classList.add('overflow-hidden');

                    const modalBg = document.createElement('div');
                    modalBg.classList = 'fixed pin bg-80 z-20 opacity-75';

                    this.modalBg = modalBg;

                    document.body.appendChild(this.modalBg);
                } else {
                    document.removeEventListener('keydown', this.handleEscape);
                    document.body.classList.remove('overflow-hidden');
                    document.body.removeChild(this.modalBg);
                }
            },
        },

        methods: {
            galleryItemSelected(item) {
                this.$emit('select', item);
                this.handleClose();
            },

            handleClose() {
                this.$emit('close');
            },

            handleEscape(e) {
                e.stopPropagation();

                if (e.keyCode === 27) {
                    this.handleClose();
                }
            },

            async refresh() {
                this.requestParams.page = 1;

                this.fireRequest().then((response) => {
                    this.items = response.data.data;
                });
            },

            async fireRequest() {
                this.loading = true;

                return this.createRequest()
                    .then((response) => {
                        return response;
                    }).finally(() => {
                        this.loading = false;
                    })
                ;
            },

            async createRequest() {
                return Nova.request()
                    .get(
                        '/nova-vendor/babdev/nova-media-library/media',
                        {
                            params: this.requestParams
                        }
                    );
            },
        },
    };
</script>
