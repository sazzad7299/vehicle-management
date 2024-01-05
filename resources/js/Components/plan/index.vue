<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Plan /</span>Plan List</h4>
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
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'plan.create' }">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                                <i class="bx bx-plus me-md-1"></i>
                                                <span class="d-md-inline-block d-none">Create Plan</span>
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
                                <select class="form-select" v-model="status">
                                    <option :value="null">Select Status</option>
                                    <option :value="status.value" class="text-capitalize"
                                        v-for="(status, index) in statuses" :key="index">{{ status.name }}
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
                                <th>Monthly Price</th>
                                <th>Annually Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(plan, index) in plans.data">
                                <td class="fw-semibold">
                                    {{ plans.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ plan.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ plan.monthly }}
                                </td>
                                <td class="fw-semibold">
                                    {{ plan.annually }}
                                </td>
                                <td class="fw-semibold">
                                    <span v-if="plan.status === 1" class="badge bg-success">Active</span>
                                    <span v-else class="badge bg-danger">Inactive</span>
                                </td>
                                <td class="text-left">
                                    <div class="demo-inline-spacing">
                                        <router-link :to="{ name: 'plan.edit', params: { id: plan.id } }">
                                            <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </router-link>
                                        <a>
                                            <button type="button" class="btn btn-sm"
                                                :class="{ 'btn-success': plan.status === 1, 'btn-danger': plan.status !== 1 }"
                                                @click="changeStatus(plan.id)">
                                                <i class="bx bx-sync mx-1"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ plans.from }}
                                to {{ plans.to }} of {{ plans.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="plans" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedPlan($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<!-- <script src="https://sandbox.sslcommerz.com/embed.min.js"></script> -->
<script>
import { defineComponent } from 'vue'
import _ from "lodash";
import {userStore} from "../../stores/user";

export default defineComponent({
    name: "index",
    data() {
        return {
            plans: {},
            planlist: {},
            search: '',
            status: null,
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            pricingarrow: '/images/pricing-arrow-light.png',
        }
    },
    watch: {
        perPage(perPage) {
            this.getPlan({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getPlan({ page: 1, search })
        }, 500),
        status: _.debounce(function (status) {
            this.getPlan({ page: 1, status })
        }, 500),
    },
    methods: {
        getPaginatedPlan(page) {
            this.getPlan({ page: page });
            this.scrollToTop();
        },
        getPlan({ page = 1, perPage = this.perPage, search = this.search, status = this.status }) {
            this.loader(true);
            axios.get('/plan', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                    status
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.plans = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        },
        changeStatus(id) {
            this.loader(true);
            axios.get('/plan/' + id)
                .then((response) => {
                    this.loader(false);
                    toastr.success(response.data.message);
                    this.getPlan({ page: this.plans.current_page });
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        },
    },
    mounted() {
        this.getPlan({ page: 1 });
        const userInfo = userStore();
    }
})
</script>
<style scoped>
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

li {
    list-style: none;
}
</style>
