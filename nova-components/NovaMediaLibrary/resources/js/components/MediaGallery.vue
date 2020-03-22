<template>
    <div class="modal select-none fixed pin z-50 overflow-x-hidden overflow-y-auto">
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            open: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                modalBg: null,
            };
        },

        created() {
            document.addEventListener('keydown', this.handleEscape);
            document.body.classList.add('overflow-hidden');

            const modalBg = document.createElement('div');
            modalBg.classList = 'fixed pin bg-80 z-20 opacity-75';

            this.modalBg = modalBg;

            document.body.appendChild(this.modalBg);
        },

        destroyed() {
            document.removeEventListener('keydown', this.handleEscape);
            document.body.classList.remove('overflow-hidden');
            document.body.removeChild(this.modalBg);
        },

        methods: {
            handleClose() {
                this.$emit('close');
            },

            handleEscape(e) {
                e.stopPropagation();

                if (e.keyCode === 27) {
                    this.handleClose();
                }
            },
        },
    };
</script>
