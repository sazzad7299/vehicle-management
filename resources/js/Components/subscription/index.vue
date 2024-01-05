
<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Subscription /</span>Subscription List</h4>
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
                                <th>Plan</th>
                                <th>Pharmacy</th>
                                <th>Started At</th>
                                <th>Expired At</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(subscribe, index) in employees.data">
                                <td class="fw-semibold">
                                    {{ employees.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ subscribe.plan.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ subscribe.pharmacy.company_name }}
                                </td>
                                
                                <td class="fw-semibold">
                                    {{$filters.customFormat( subscribe.started_at)  }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $filters.customFormat( subscribe.expired_at) }}
                                </td>
                                <!-- <td class="text-left">
                                    <div class="demo-inline-spacing">
                                        <router-link :to="{ name: 'plan.edit', params: { id: plan.id } }">
                                            <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </router-link>
                                       
                                        <a>
                                            <button type="button" class="btn btn-sm btn-success" title="renew"
                                                @click="changeStatus(subscribe.id)">
                                                <i class="bx bx-sync mx-1"></i>
                                            </button>
                                        </a> 
                                    </div>
                                </td> -->
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
            axios.get('/subscription', {
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
    },
    mounted() {
        this.getemployee({ page: 1 });
    }
}
</script>

<style scoped></style>

