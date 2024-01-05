<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Customers /</span>Customer List</h4>
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
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3" v-if="hasPermission('customer.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'customer.create' }">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                                <i class="bx bx-plus me-md-1"></i>
                                                <span class="d-md-inline-block d-none">Create Customer</span>
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
                                <th>Phone No</th>
                                <th>Purchase</th>
                                <th>Return</th>
                                <th>Paid</th>
                                <th>Cash Back</th>
                                <th>Due</th>
                                <th v-if="hasPermission('customer.edit') || hasPermission('customer.view') || hasPermission('customer.delete')">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(user, index) in users.data">
                                <td class="fw-semibold">
                                    {{ users.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ user.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ user.phone }}
                                </td>
                                <td>
                                    {{ user.sales_sum_total !== null ? user.sales_sum_total : 0 }}
                                </td>
                                <td>
                                    {{ user.sale_return_sum_price !== null ? user.sale_return_sum_price : 0 }}
                                </td>
                                <td>
                                    {{ user.sale_payments_sum_paid !== null ? user.sale_payments_sum_paid : 0 }}
                                </td>
                                <td>
                                    {{ user.sale_return_sum_return_amount !== null ? user.sale_return_sum_return_amount : 0
                                    }}
                                </td>
                                <td>{{ (user.sales_sum_total - user.sale_payments_sum_paid) - (user.sale_return_sum_price -
                                    user.sale_return_sum_return_amount) }}</td>
                                <td class="d-flex px-1 justify-content-around" v-if="hasPermission('customer.edit') || hasPermission('customer.view') || hasPermission('customer.delete')">
                                    <router-link :to="{ name: 'customer.edit', params: { id: user.id } }" v-if="hasPermission('customer.edit')">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </router-link>
                                    <router-link :to="{ name: 'customer.view', params: { id: user.id } }"  v-if="hasPermission('customer.view')">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class='bx bxs-bullseye'></i>
                                        </button>
                                    </router-link>
                                    <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                        @click="softDeleteUser(user)"  v-if="hasPermission('customer.delete')">
                                        <i class="bx bx-trash-alt mx-1"></i>
                                    </button>
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
                                @pagination-change-page="getPaginatedUser($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { collect } from "collect.js";

export default {
    name: 'User Index',
    data() {
        return {
            users: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getUser({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getUser({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedUser(page) {
            this.getUser({ page: page });
            this.scrollToTop();
        },
        getUser({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/customer', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.users = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeleteUser(user) {
            const confirmed = window.confirm('Are you sure you want to delete this user?');
            if (confirmed) {
                this.loader(true);
                axios.delete('customer/' + user.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getUser({ page: 1 });
                        }

                    })
                    .catch(error => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        }
    },
    mounted() {
        this.getUser({ page: 1 });
    }
}
</script>

<style scoped></style>
