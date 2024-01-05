<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permission Role /</span>
            <router-link :to="{name: 'permission.index'}">
                Permission List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Create Permission</h5>
                    <div class="card-body">
                        <form @submit.prevent="createPermission">
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label form-label" for="basic-default-name">Name<span
                                    class="text-danger">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                           autocomplete="off" v-model="permissionForm.name">
                                    <span v-if="this.allErrors.has('name')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="d-grid gap-2 col-lg-1 mx-auto">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../../errors/errors";

export default {
    data() {
        return {
            allErrors: new Errors(),
            permissionForm: {
                name: '',
            },
        }
    },
    methods: {
        createPermission() {
            this.loader(true);
            axios.post('/rbac/permissions', {
                ...this.permissionForm
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({name: 'permission.index'});
                    }
                })
                .catch(error => {
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                    this.loader();
                })
        }
    }
}

</script>
<style scoped>

</style>
