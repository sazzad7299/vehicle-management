<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Driver /</span>Driver List</h4>
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
                                v-if="hasPermission('medicine.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'medicine.create' }">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                                <i class="bx bx-plus me-md-1"></i>
                                                <span class="d-md-inline-block d-none">Add Driver</span>
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
                                <th>Model</th>
                                <th>Name</th>
                                <th>License</th>
                                <th>Driver</th>
                                <th>Expire at</th>
                                <th  v-if="hasPermission('medicine.edit') || hasPermission('medicine.delete') ">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(medicine, index) in medicines.data" :key="medicine.id">
                                <td class="fw-semibold">
                                    {{ medicines.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ medicine.barcode }}
                                </td>
                                <td class="fw-semibold">
                                    {{ medicine.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ medicine.generic }}
                                </td>
                                <td class="fw-semibold">
                                    {{ medicine.manufacturer.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{$filters.customFormat(medicine.description) }}
                                </td>
                                <td class="d-flex py-2px-2" v-if="hasPermission('medicine.edit') || hasPermission('medicine.delete') ">
                                    <div class="mx-2" v-if="hasPermission('medicine.edit')">
                                        <router-link :to="{ name: 'medicine.edit', params: { id: medicine.id } }">
                                            <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </router-link>
                                    </div>
                                    <div v-if="hasPermission('medicine.delete') ">
                                        <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                            @click="softDeleteMedicine(medicine)">
                                            <i class="bx bx-trash-alt mx-1"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ medicines.from }}
                                to {{ medicines.to }} of {{ medicines.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="medicines" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedMedicine($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { collect } from "collect.js";

export default {
    name: 'Medicine List',
    data() {
        return {
            medicines: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getMedicine({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getMedicine({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedMedicine(page) {
            this.getMedicine({ page: page });
            this.scrollToTop();
        },
        getMedicine({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/medicine', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.medicines = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeleteMedicine(medicine) {
            const confirmed = window.confirm('Are you sure to delete this Vehicle?');
            if (confirmed) {
                this.loader(true);
                axios.delete('medicine/' + medicine.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getMedicine({ page: 1 });
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
        this.getMedicine({ page: 1 });
    }
}
</script>

<style scoped></style>
