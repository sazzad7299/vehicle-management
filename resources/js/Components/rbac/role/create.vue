<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Create Role /</span>
            <router-link :to="{name: 'role.index'}">
                Role List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Create Role</h5>
                    <div class="card-body">
                        <form @submit.prevent="createRole" @keydown="allErrors.clear($event.target.name)">
                            <div class="row mb-3">
                                
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label form-label" for="basic-default-name">Name<span
                                        class="text-danger">*</span> </label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                           autocomplete="off" v-model="roleForm.name">
                                    <span v-if="this.allErrors.has('name')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label form-label" for="basic-default-name">Access By<span
                                        class="text-danger">*</span> </label>
                                    </div>
                                    <v-select :options="options" :label="'title'" :reduce="option=>option.value" placeholder="Select Access Permission" v-model="roleForm.access_by"></v-select>
                                    <span v-if="this.allErrors.has('access_by')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('access_by')">
                                    </span>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label form-label" for="basic-default-name">Status<span
                                        class="text-danger">*</span> </label>
                                    </div>
                                    <v-select :options="status" :label="'title'" :reduce="option=>option.value" placeholder="Select Status" v-model="roleForm.status"></v-select>
                                    <span v-if="this.allErrors.has('status')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('status')">
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
            roleForm: {
                name: '',
                status:1,
                access_by:1,
            },
            options:[
                {value:0,title:"All users"},
                {value:1,title:"Only For Us"},
            ],
            status:[
            {value:1,title:"Active"},
                {value:0,title:"Inactive"},
            ]
        }
    },
    methods: {
        createRole() {
            this.loader(true);
            axios.post('/rbac/roles', {
                ...this.roleForm
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({name: 'role.index'});
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
