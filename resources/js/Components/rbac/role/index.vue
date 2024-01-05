<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Roles /</span>Roles List</h4>
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row ms-2 me-3">
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <div class="dataTables_length">
                                <label>
                                    <select v-model.number="perPage" class="form-select">
                                        <option :value="item" v-for="(item, index) in items" :key="index">{{
                                            item
                                        }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"
                                v-if="hasPermission('role.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'role.create' }">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                                <i class="bx bx-plus me-md-1"></i>
                                                <span class="d-md-inline-block d-none">Create Role</span>
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
                        </div>
                    </div>
                    <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(role, index) in roles.data">
                                <td class="fw-semibold">
                                    {{ index + roles.from }}
                                </td>
                                <td class="fw-semibold">
                                    {{ role.name }}
                                </td>
                                <td class="text-left">
                                    <div class="demo-inline-spacing">
                                        <router-link :to="{ name: 'role.edit', params: { id: role.id } }"
                                            v-if="hasPermission('role.edit')">
                                            <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </router-link>

                                        <router-link :to="{ name: 'role.assign-permission', params: { id: role.id } }"
                                            v-if="hasPermission('role.assign-permission')">
                                            <button type="button" class="btn btn-sm btn-success hide-arrow">
                                                <i class='bx bxs-zoom-in'></i>
                                            </button>
                                        </router-link>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ roles.from }}
                                to {{ roles.to }} of {{ roles.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="roles" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedRoles($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name: 'Role Index',
    data() {
        return {
            roles: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],

        }
    },
    watch: {
        perPage(perPage) {
            this.getRoles({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getRoles({ page: 1, search })
        }, 500),
    },
    methods: {
        getPaginatedRoles(page) {
            this.getRoles({ page: page });
            this.scrollToTop();
        },
        getRoles({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/rbac/roles', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.roles = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        }
    },
    mounted() {
        this.getRoles({ page: 1 });

    }

}
</script>

<style scoped></style>
