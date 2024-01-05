<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Balance /</span>Balance List
        </h4>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-3 col-sm-6 mb-2" v-for="(method, index) in balance" :key="index">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ method.name }}</h5>
                        <h6 class="card-subtitle mt-2">Balance:{{ method.current_balance }}</h6>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row ms-2 me-3">
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <div class="dataTables_length">
                                <label>
                                    <select v-model.number="perPage" class="form-select">
                                        <option :value="item" v-for="(item, index) in items" :key="index">
                                            {{ item }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"
                                v-if="hasPermission('balance.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <button class="btn btn-secondary btn-primary" type="button" @click="openAddModal">
                                        <span>
                                            <i class="bx bx-plus me-md-1"></i>
                                            <span class="d-md-inline-block d-none">Balance In/Out</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-2">
                            <div class="dataTables_filter d-flex gap-2">
                                <select name="type" required class="form-control" v-model="filter.type" @change="getUnit">
                                    <option value="" selected>Select Type</option>
                                    <option value="1">Balance IN</option>
                                    <option value="2">Balance Out</option>
                                </select>
                                <select name="payment_method" v-model="filter.method" required class="form-control"
                                    @change="getUnit">
                                    <option value="" selected>Select Method</option>
                                    <option v-for="(method, index) in balance" :key="index" :value="method.id">{{
                                        method.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>In/Out</th>
                                <th>Methods</th>
                                <th v-if="hasPermission('balance.edit') || hasPermission('balance.delete')">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="units && units.data && units.data.length > 0">
                                <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(unit, index) in units.data">
                                    <td class="fw-semibold">
                                        {{ units.from + index }}
                                    </td>
                                    <td class="fw-semibold">
                                        {{ unit.date }}
                                    </td>
                                    <td class="fw-semibold">
                                        {{ unit.amount }}
                                    </td>
                                    <td class="fw-semibold">
                                        <span v-if="unit.type == 1" class="text-success">Balance In</span>
                                        <span v-else class="text-danger">Balance Out</span>
                                    </td>
                                    <td class="fw-semibold">
                                        {{ unit.payment_method.name }}
                                    </td>
                                    <td class="d-flex py-2px-2" v-if="hasPermission('balance.edit') || hasPermission('balance.delete')">
                                        <div class="mx-2" v-if="hasPermission('balance.edit')">
                                            <button type="button" class="btn btn-sm btn-primary hide-arrow"
                                                @click="openEditModal(unit)">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </div>
                                        <div v-if="hasPermission('balance.delete')">
                                            <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                                @click="softDeleteUnit(unit)">
                                                <i class="bx bx-trash-alt mx-1"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="6" class="text-center">No Data Found</td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ units.from }} to {{ units.to }} of
                                {{ units.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="units" :limit="10" :align="'right'" @pagination-change-page="
                                getPaginatedUnit($event)
                                " />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <unit-modal :is-open="isModalOpen" :mode="modalMode" :unit-data="modalUnitData" :methoddata="balance"
        @submit="handleModalSubmit" @close="closeModal"
        @typeAdded="this.getUnit({ page: 1 }), this.currenBalance()"></unit-modal>
</template>

<script>
import _ from "lodash";
import { handleErrorResponse } from "../../errors/errorHandler.js";
import { handleSuccessResponse } from "../../errors/successHandler.js";
import { collect } from "collect.js";
import UnitModal from "./leafModal.vue";

export default {
    components: {
        UnitModal,
    },
    name: "Balance Info",
    data() {
        return {
            units: {},
            balance: {},
            search: "",
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            isModalOpen: false,
            modalMode: "",
            modalUnitData: null,
            units: [],
            filter: { type: '', method: '' },
        };
    },
    watch: {
        perPage(perPage) {
            this.getUnit({ page: 1, perPage });
        },

    },
    methods: {
        collect,
        getPaginatedUnit(page) {
            this.getUnit({ page: page });
            this.scrollToTop();
        },
        currenBalance() {
            axios
                .get("/current-balance")
                .then((response) => {
                    this.loader(false);
                    this.balance = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                });
        },
        getUnit({ page = 1, perPage = this.perPage, filter = this.filter }) {
            this.loader(true);
            axios
                .get("/balance-info", {
                    params: {
                        page,
                        per_page: perPage,
                        type: filter.type,
                        method: filter.method,
                    },
                })
                .then((response) => {
                    this.loader(false);
                    this.units = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                });
        },
        softDeleteUnit(unit) {
            const confirmed = window.confirm(
                "Are you sure you want to delete this Balance?"
            );
            if (confirmed) {
                this.loader(true);
                axios
                    .delete("balance-info/" + unit.id)
                    .then((response) => {
                        handleSuccessResponse.call(this, response);
                        this.getUnit({
                            page: 1,
                        });
                        this.currenBalance();
                    })
                    .catch((error) => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
        openAddModal() {
            this.isModalOpen = true;
            this.modalMode = "add";
        },
        openEditModal(unit) {
            this.isModalOpen = true;
            this.modalMode = "edit";
            if (unit.status === 1) {
                unit.status = true;
            } else {
                unit.status = false;
            }
            this.modalUnitData = unit;
        },

        closeModal() {
            this.isModalOpen = false;
            this.modalMode = "";
            this.modalUnitData = null;
        },
    },
    mounted() {
        this.getUnit({ page: 1 });
        this.currenBalance();
    },
};
</script>

<style scoped></style>
