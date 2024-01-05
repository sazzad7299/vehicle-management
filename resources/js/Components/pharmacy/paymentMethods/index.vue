<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Payment Methods /</span>Payment Methods
        </h4>
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
                                v-if="hasPermission('payment-method.add')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <button class="btn btn-secondary btn-primary" type="button" @click=" openAddModal ">
                                        <span>
                                            <i class="bx bx-plus me-md-1"></i>
                                            <span class="d-md-inline-block d-none">Add New</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-2">
                            <div class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control" placeholder="Search" v-model=" search "
                                        aria-controls="DataTables_Table_0" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Account</th>
                                <th>Status</th>
                                <th v-if="hasPermission('payment-method.edit') || hasPermission('payment-method.delete')">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class=" index % 2 === 0 ? 'odd' : 'even'" v-for="( unit, index ) in  units.data ">
                                <td class="fw-semibold">
                                    {{ units.from + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ unit.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ unit.description }}
                                </td>
                                <td class="fw-semibold" v-if=" unit.status == 1 ">
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td class="fw-semibold" v-if=" unit.status == 0 ">
                                    <span class="badge bg-dark">Inactive</span>
                                </td>
                                <td class="d-flex py-2px-2" v-if="hasPermission('payment-method.edit')">
                                    <div class="mx-2" v-if="hasPermission('payment-method.edit') || hasPermission('payment-method.delete')">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow"
                                            @click="openEditModal(unit)">
                                            <i class="bx bx-edit-alt mx-1"></i>
                                        </button>
                                    </div>
                                    <div v-if="hasPermission('payment-method.delete')">
                                        <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                            @click="softDeleteUnit(unit)">
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
                                Showing {{ units.from }} to {{ units.to }} of
                                {{ units.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data=" units " :limit=" 10" :align=" 'right'" @pagination-change-page="
                                getPaginatedUnit($event)
                                " />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <unit-modal :is-open=" isModalOpen " :mode=" modalMode " :unit-data=" modalUnitData " @submit=" handleModalSubmit "
        @close=" closeModal " @typeAdded="this.getUnit({ page: 1 })"></unit-modal>
</template>

<script>
import _ from "lodash";
import { handleErrorResponse } from "../../../errors/errorHandler.js";
import { handleSuccessResponse } from "../../../errors/successHandler.js";
import { collect } from "collect.js";
import UnitModal from "./methodModal.vue";

export default {
    components: {
        UnitModal,
    },
    name: "Payment Methods",
    data() {
        return {
            units: {},
            search: "",
            perPage: 10,
            items: [10, 20, 30, 40, 50],
            isModalOpen: false,
            modalMode: "",
            modalUnitData: null,
            units: [],
        };
    },
    watch: {
        perPage(perPage) {
            this.getUnit({ page: 1, perPage });
        },
        search: _.debounce(function (search) {
            this.getUnit({ page: 1, search });
        }, 500),
    },
    methods: {
        collect,
        getPaginatedUnit(page) {
            this.getUnit({ page: page });
            this.scrollToTop();
        },
        getUnit({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios
                .get("/payment-method", {
                    params: {
                        page,
                        per_page: perPage,
                        search,
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
                "Are you sure you want to delete this Payment Method?"
            );
            if (confirmed) {
                this.loader(true);
                axios
                    .delete("payment-method/" + unit.id)
                    .then((response) => {
                        handleSuccessResponse.call(this, response);
                        this.getUnit({
                            page: 1,
                        });
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
    },
};
</script>

<style scoped></style>
