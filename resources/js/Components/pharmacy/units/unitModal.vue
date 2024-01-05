<template>
    <div class="modal" v-if="isOpen">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">{{ mode === 'add' ? 'Add Unit' : 'Edit Unit' }}</h5>
                    <button type="button" class="btn-close" aria-label="Close" @click="closeModal"></button>
                </div>
                <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameSmall" class="form-label">Name</label>
                                <input type="text" v-model="unit.name" required class="form-control"
                                    placeholder="Unit Name" name="name" />
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                            v-text="this.allErrors.get('name')">
                                        </span>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-8 mb-0">
                                <label class="form-label" for="emailSmall">Note</label>
                                <input type="text" class="form-control" id="emailSmall" placeholder="Notes"
                                    v-model="unit.description" name="description" />
                                    <span v-if="this.allErrors.has('description')" class="error text-danger fw-semibold mt-3"
                                                v-text="this.allErrors.get('description')">
                                            </span>
                            </div>
                            <div class="col-4 mb-0">
                                <label class="form-label" for="basic-default-name">Status<span
                                        class="text-danger">*</span></label>
                                <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                    <input class="form-check-input switch-lg" type="checkbox" v-model="unit.status">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" @click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ mode === 'add' ? 'Add' : 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
    props: {
        isOpen: Boolean,
        mode: {
            type: String,
            default: 'add' // 'add' or 'edit'
        },
        unitData: Object // Used for pre-populating form fields in edit mode
    },
    data() {
        return {
            allErrors: new Errors(),
            unit: {
                name: '',
                description: '',
                status: true
            }
        };
    },
    watch: {
        unitData: {
            immediate: true,
            handler(newVal) {
                if (this.mode === 'edit' && newVal) {
                    this.unit = { ...newVal }; // Copy the unitData object to the unit data property
                }
            }
        }
    },
    methods: {
        handleSubmit() {
            if (this.mode === 'add') {
                this.loader(true);
                axios.post('unit', { ...this.unit })
                    .then(response => {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.clearData()
                         this.$emit('unitAdded');

                    })
                    .catch(error => {
                         this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            } else if (this.mode === 'edit') {
                axios
                    .put(`unit/${this.unit.id}`, { ...this.unit })
                    .then((response) => {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.$emit('unitAdded');
                    })
                    .catch((error) => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
        closeModal() {
            this.$emit('close');
            this.clearData();
        },
        clearData() {
            this.unit = {
                name: '',
                description: '',
                status:true,
            }
        }
    },
};
</script>

<style scoped>
/* Styles for the modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-check-input {
    width: 60px !important;
    height: 30px !important;
}
</style>
