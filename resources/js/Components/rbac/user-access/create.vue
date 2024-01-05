<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Grant Access /</span>
            <router-link :to="{name: 'user-access.index'}">User Access List</router-link>
        </h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Grant Role</h5>
                    <div class="card-body">
                        <form @submit.prevent="grantAccess">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label class="form-label">User<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <v-select :options="users"
                                              :label="'name'"
                                              name="user_id"
                                              :placeholder="'Select User'"
                                              :reduce="user => user.id"
                                              v-model="grant.user_id"
                                              @update:modelValue="this.allErrors.clear(`user_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('user_id')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('user_id')"></span>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Role<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <v-select
                                        :options="roles"
                                        :label="'name'"
                                        name="role_id"
                                        :placeholder="'Select Role'"
                                        :reduce="role => role.id"
                                        v-model="grant.role_id"
                                        @update:modelValue="this.allErrors.clear(`role_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('role_id')"
                                          class="error text-danger text-bold ms-2 mt-2"
                                          v-text="this.allErrors.get('role_id')"></span>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-1">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="submit">Grant</button>
                                    </div>
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
import {defineComponent} from 'vue'
import Errors from "../../../errors/errors";

export default defineComponent({
    name: "create",
    data() {
        return {
            allErrors: new Errors(),
            roles: [],
            users: [],
            grant: {
                user_id: '',
                role_id: '',
            }

        }
    },
    methods: {
        getUserAndRoles() {
            axios.get('/rbac/user-access/create')
                .then((response) => {
                    this.roles = response.data.result.roles;
                    this.users = response.data.result.users;
                })
                .catch((error) => {
                    toastr.error(error);
                })
        },
        grantAccess() {
            this.loader(true);
            axios.post('/rbac/user-access', {
                ...this.grant
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({name: 'user-access.index'});
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
    },
    mounted() {
        this.getUserAndRoles();
    }
})
</script>
<style scoped>

</style>
