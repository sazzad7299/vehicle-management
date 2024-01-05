<template>
    <div class="container-xxl flex-grow-1 container-p-y">
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
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>User Name</th>
                                <th>Pharmacy Name</th>
                                <th>Activity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(activity, index) in activities.data">
                                <td class="fw-semibold">
                                    {{ activities.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ activity.user_name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ activity.pharmacy_name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ activity.activity }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $filters.customFormat(activity.created_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ activities.from }}
                                to {{ activities.to }} of {{ activities.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="activities" :limit="10" :align="'right'"
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
            activities: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.activityLogs({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.activityLogs({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedemployee(page) {
            this.activityLogs({ page: page });
            this.scrollToTop();
        },
        activityLogs({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/activity-logs', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.activities = response.data;
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
                            this.activityLogs({ page: 1 });
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
        this.activityLogs({ page: 1 });
    }
}
</script>

<style scoped></style>
