<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employee /</span>Employee List</h4>
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
                                v-if="hasPermission('employee.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'employee.create' }">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                                <i class="bx bx-plus me-md-1"></i>
                                                <span class="d-md-inline-block d-none">Create Employee</span>
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
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>Email</th>
                                <th>Joining</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(employee, index) in employees.data">
                                <td class="fw-semibold">
                                    {{ employees.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ employee.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ employee.phone }}
                                </td>
                                <td class="fw-semibold">
                                    {{ employee.email }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $filters.customFormat(employee.joining_date) }}
                                </td>
                                <td class="fw-semibold">
                                    {{ employee.salary }}
                                </td>
                                <td class="fw-semibold">
                                    <span class="badge bg-success"
                                        :class="employee.status == 1 ? 'bg-success' : 'bg-dark'">{{ employee.status == 1 ?
                                            'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="d-flex px-1 justify-content-around">
                                    <router-link :to="{ name: 'employee.edit', params: { id: employee.id } }"
                                        v-if="hasPermission('employee.edit')">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </router-link>
                                    <router-link :to="{ name: 'employee.view', params: { id: employee.id } }"
                                        v-if="hasPermission('employee.view')">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class='bx bxs-bullseye'></i>
                                        </button>
                                    </router-link>
                                    <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                        @click="softDeleteemployee(employee)" v-if="hasPermission('employee.delete')">
                                        <i class="bx bx-trash-alt mx-1"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ employees.from }}
                                to {{ employees.to }} of {{ employees.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="employees" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedemployee($event)" />
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
    name: 'employee Index',
    data() {
        return {
            employees: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getemployee({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getemployee({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedemployee(page) {
            this.getemployee({ page: page });
            this.scrollToTop();
        },
        getemployee({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/employee', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.employees = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeleteemployee(employee) {
            const confirmed = window.confirm('Are you sure you want to delete this employee?');
            if (confirmed) {
                this.loader(true);
                axios.delete('employee/' + employee.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getemployee({ page: 1 });
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
        this.getemployee({ page: 1 });
    }
}
</script>

<style scoped></style>
