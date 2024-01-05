<template lang="">
    <div class="modal fade show" id="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ content.name }}</h5>
                        <button type="button" class="btn-close"  @click="close"></button>
                    </div>
                    <div class="modal-body" v-html="content.text"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  @click="close">Close</button>
                        <button type="button" class="btn btn-primary" @click="accept">Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <script>
    export default {
        data() {
            return {
                content: {},
            };
        },
        methods: {
            accept(){
                this.$emit('accept');
            },
            close(){
                this.$emit('close');
            }
        },
        created() {
            axios.get("https://admin.amarlodge.com/api/pages/21/content")
                .then((response) => {
                    this.content = response.data.data;
                })
                .catch((error) => {

                });
        }
    }
    </script>

<style scoped>
/* Styles for the modal */
.modal {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100% !important;
}
</style>