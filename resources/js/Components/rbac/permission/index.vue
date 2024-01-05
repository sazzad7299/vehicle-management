<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permissions  /</span>Permissions List</h4>
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
                                    <router-link :to="{ name: 'permission.create'}">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                              <i class="bx bx-plus me-md-1"></i>
                                              <span class="d-md-inline-block d-none">Create Permissions</span>
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
                        <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(permission, index) in permissions.data">
                            <td class="fw-semibold">
                                {{ index + permissions.from }}
                            </td>
                            <td class="fw-semibold">
                                {{ permission.display_name }}
                            </td>
                            <td class="text-left">
                                <div class="demo-inline-spacing">
                                    <router-link :to="{ name: 'permission.edit',params:{ id:permission.id }}">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class="bx bx-edit-alt mx-1"></i>
                                        </button>
                                    </router-link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" permission="status" aria-live="polite">
                                Showing {{ permissions.from }}
                                to {{ permissions.to }} of {{ permissions.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="permissions" :limit="10" :align="'right'"
                                        @pagination-change-page="getPaginatedPermissions($event)"/>
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
    data() {
        return {
            permissions: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getPermissions({page: 1, perPage})
        },
        search: _.debounce(function (search) {
            this.getPermissions({page: 1, search})
        }, 500),
    },
    methods: {

        getPaginatedPermissions(page) {
            this.getPermissions({page: page});
            this.scrollToTop();
        },
        getPermissions({page = 1, perPage = this.perPage, search = this.search}) {
            this.loader(true);
            axios.get('/rbac/permissions', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.permissions = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        }
    },
    mounted() {
        this.getPermissions({page: 1});
    }
}
</script>

<style scoped>

</style>
