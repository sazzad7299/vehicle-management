<template>
    <div class="card mb-4">
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
                            <th>Detaisl</th>
                            <th>Status</th>
                            <th v-if="hasPermission('category.edit') || hasPermission('category.delete')">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(category, index) in categories.data">
                            <td class="fw-semibold">
                                {{ categories.from + index }}
                            </td>
                            <td class="fw-semibold">
                                {{ category.name }}
                            </td>
                            <td class="fw-semibold">
                                {{ category.description }}
                            </td>
                            <td class="fw-semibold" v-if="category.status == 1">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="fw-semibold" v-if="category.status == 0">
                                <span class="badge bg-dark">Inactive</span>
                            </td>
                            <td class="d-flex py-2px-2" v-if="hasPermission('category.edit') || hasPermission('category.delete')">
                                <div class="mx-2" v-if="hasPermission('category.edit')">
                                    <button type="button" class="btn btn-sm btn-primary hide-arrow" @click="editCategory(category)">
                                        <i class="bx bx-edit-alt mx-1"></i>
                                    </button>
                                </div>
                                <div v-if="hasPermission('category.delete')">
                                    <button type="button" class="btn btn-sm btn-danger hide-arrow"
                                        @click="softDeleteCategory(category)">
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
                            Showing {{ categories.from }}
                            to {{ categories.to }} of {{ categories.total }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination :data="categories" :limit="10" :align="'right'"
                            @pagination-change-page="getPaginatedCategory($event)" />
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
    props: {
        categories: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            categories: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        };
    },
       watch: {
        perPage(perPage) {
            this.getCategory({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getCategory({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedCategory(page) {
            this.getCategory({ page: page });
            this.scrollToTop();
        },
        getCategory({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/category', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.categories = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeleteCategory(category) {
            const confirmed = window.confirm('Are you sure you want to delete this Department?');
            if (confirmed) {
                this.loader(true);
                axios.delete('category/' + category.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getCategory({ page: 1 });
                        }

                    })
                    .catch(error => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
        editCategory(category) {
            if (category.status == 0) {
                category.status = false;
            } else {
                category.status = true;
            }
            this.$emit('edit-category', category); // Emit an event with the category data
        },
    },
    mounted() {
        this.getCategory({ page: 1 });
    },
};
</script>
