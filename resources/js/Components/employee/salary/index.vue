<template>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row ms-2 me-3">
                        <h4 class="fw-bold mt-4">Salary List</h4>
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
                                v-if="hasPermission('salary.create')">
                                <div class="dt-buttons btn-group flex-wrap">

                                    <button class="btn btn-secondary btn-primary" type="button" @click="openAddModal" data-bs-toggle="modal" data-bs-target="#modalCenterTitle">
                                        <span>
                                            <i class="bx bx-plus me-md-1"></i>
                                            <span class="d-md-inline-block d-none">New Salary</span>
                                        </span>
                                    </button>
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
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(salary, index) in salaries.data">
                                <td class="fw-semibold">
                                    {{ salaries.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $filters.MYFormat(salary.month) }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.employee.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.employee.phone }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.totalPaid }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ salaries.from }}
                                to {{ salaries.to }} of {{ salaries.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="salaries" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedsalary($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <create-modal :is-open="isModalOpen" :mode="modalMode"
         @close="closeModal" @salaryPaid="getSalary({ page: 1 })"></create-modal>
</template>

<script>
import _ from "lodash";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import CreateModal from './create.vue'
export default {
    name: 'salary Index',
    components: {
        CreateModal,
    },
    data() {
        return {
            salaries: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            isModalOpen: false,
            modalMode: "",
        }
    },
    watch: {
        perPage(perPage) {
            this.getsalary({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getsalary({ page: 1, search })
        }, 500),
    },
    methods: {
        getPaginatedsalary(page) {
            this.getsalary({ page: page });
            this.scrollToTop();
        },
        getSalary({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/employee-salary', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.salaries = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeletesalary(salary) {
            const confirmed = window.confirm('Are you sure you want to delete this salary?');
            if (confirmed) {
                this.loader(true);
                axios.delete('customer/' + salary.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getsalary({ page: 1 });
                        }

                    })
                    .catch(error => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
        openAddModal() {
            this.isModalOpen = true;
            this.modalMode = "add";
        },
        closeModal() {
            this.isModalOpen = false;
            this.modalMode = "";
            this.modalUnitData = null;
        },
    },
    mounted() {
        this.getSalary({ page: 1 });
    }
}
</script>

<style scoped></style>
