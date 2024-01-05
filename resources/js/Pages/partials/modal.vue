<template>
    <div class="modal fade" id="modal" tabindex="-1" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        modalTitle: {
            type: String,
            default: "Modal title"
        }
    },
    data() {
        return {
            modal: null
        }
    },
    methods: {
        show() {
            this.modal.show();
        },
        hide() {
            this.modal.hide();
        }
    },
};
</script>
