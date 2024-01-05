<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users  /</span>Users List</h4>
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row ms-2 me-3">
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <div class="dataTables_length">
                                <label>
                                    <select v-model.number="perPage" class="form-select">
                                        <option :value="item" v-for="(item,index) in items" :key="index">{{
                                                item
                                            }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'user-access.create'}">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                              <i class="bx bx-plus me-md-1"></i>
                                              <span class="d-md-inline-block d-none">Grant Role</span>
                                            </span>
                                        </button>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-2">
                            <div class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control" placeholder="Search" v-model="search"
                                           aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                            <div class="invoice_status mb-3 mb-md-0">
                                <select class="form-select" v-model="role">
                                    <option :value="null">Select Role</option>
                                    <option :value="role.id" class="text-capitalize" v-for="(role,index) in roles"
                                            :key="index">{{ role.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(user, index) in users.data">
                            <td class="fw-semibold">
                                {{ index + users.from }}
                            </td>
                            <td class="fw-semibold">
                                {{ user.name }}
                            </td>
                            <td class="fw-semibold">
                                {{ collect(user.roles).pluck('name').implode(', ') }}
                            </td>
                            <td class="text-left">
                                <div class="demo-inline-spacing">
<!--                                    <router-link :to="{ name: 'role.edit',params:{ id:user.id }}">-->
<!--                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">-->
<!--                                            <i class="bx bx-edit-alt mx-1"></i>-->
<!--                                        </button>-->
<!--                                    </router-link>-->

<!--                                    <router-link :to="{ name: 'role.assign-permission',params:{ id:user.id }}">-->
<!--                                        <button type="button" class="btn btn-sm btn-success hide-arrow">-->
<!--                                            <i class='bx bxs-zoom-in'></i>-->
<!--                                        </button>-->
<!--                                    </router-link>-->
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ users.from }}
                                to {{ users.to }} of {{ users.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="users" :limit="10" :align="'right'"
                                        @pagination-change-page="getPaginatedUsers($event)"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import {collect} from "collect.js";

export default {
    name: 'User Access Index',
    data() {
        return {
            users: {},
            roles: [],
            search: '',
            role: null,
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getUsers({page: 1, perPage})
        },
        search: _.debounce(function (search) {
            this.getUsers({page: 1, search})
        }, 500),
        role: _.debounce(function (role) {
            this.getUsers({page: 1, role})
        }, 500),
    },
    methods: {
        collect,
        getPaginatedUsers(page) {
            this.getUsers({page: page});
            this.scrollToTop();
        },
        getUsers({page = 1, perPage = this.perPage, search = this.search, role = this.role}) {
            this.loader(true);
            axios.get('/rbac/user-access', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                    role,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.users = response.data.result.users;
                    this.roles = response.data.result.roles;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);

                })
        },
        getPermissions(){
            this.loader(true);
            axios.get('/get-permissions')
                .then((response) => {
                    this.loader(false);
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        }
    },
    mounted() {
        this.getUsers({page: 1});
    }

}
</script>

<style scoped>

</style>
