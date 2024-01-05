<template>
    <div class="card mb-4">
        <h5 class="card-header fw-bold">{{ category ? 'Update' : 'Add' }} Department</h5>
        <div class="card-body">
            <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Department Name</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe"
                                v-model="formData.name" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Description</label>
                            <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc."
                                v-model="formData.description" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">Status<span
                                    class="text-danger">*</span></label>
                            <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                <input class="form-check-input switch-lg" type="checkbox" v-model="formData.status" />
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ category ? 'Update' : 'Add' }}</button>
            </form>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Errors from "../../../errors/errors";
export default {
    props: {
        category: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            allErrors: new Errors(),
            formData: {
                name: '',
                description: '',
                status: true,
            },
        };
    },
    methods: {
        handleSubmit() {
            if (!this.category) {
                // If the category doesn't have an ID, it means it's a new category (create operation)
                this.createCategory();
            } else {
                // If the category has an ID, it means it's an existing category (update operation)
                this.updateCategory();
            }
        },
        createCategory() {
            this.loader(true);
            axios
                .post('category', { ...this.formData })
                .then((response) => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.result);
                        this.formData = {
                            name: '',
                            description: '',
                            status: true,
                        };
                        this.getUser({ page: 1 });
                    }
                })
                .catch((error) => {
                    this.loader(false);
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                });
        },
        updateCategory() {
            this.loader(true);
            axios
                .put(`category/${this.category.id}`, { ...this.formData })
                .then((response) => {
                    if (response.status === 200) {
                        this.loader(false);
                        toastr.success(response.data.result);
                        this.formData = {
                            name: '',
                            description: '',
                            status: true,
                        };
                        this.getCategory({ page: 1 });
                    }
                })
                .catch((error) => {
                    this.loader(false);
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                });
        },
    },
    watch: {
        category(newData) {
            this.formData = { ...newData };
        },
    },
};
</script>

<style scoped>
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}
</style>
