<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sale /</span>Sale Return List</h4>
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
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Return</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="returns && returns.data">
                                <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(product, index) in returns.data">
                                <td class="fw-semibold">
                                    {{ returns.from + index }}
                                </td>
                                <td>{{ $filters.customFormat(product.created_at) }}</td>
                                <td>{{ product.customer.name }}</td>
                                <td class="fw-semibold">
                                    {{ product.medicine.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ product.quantity }}
                                </td>
                                <td class="fw-semibold">
                                    {{ product.price }}
                                </td>
                                <td class="fw-semibold">
                                    {{ product.returnAmount }} TK
                                </td>
                                <td class="fw-semibold">
                                   <span v-if="product.payment_method">  {{ product.payment_method.name }}</span>
                                   <span v-else>No payment</span>
                                </td>
                            </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ returns.from }}
                                to {{ returns.to }} of {{ returns.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="returns" :limit="10" :align="'right'"
                                @pagination-change-page="getPaginatedproduct($event)" />
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
    name: 'Return List',
    data() {
        return {
            returns: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getSaleReturn({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getSaleReturn({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedproduct(page) {
            this.getSaleReturn({ page: page });
            this.scrollToTop();
        },
        getSaleReturn({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/sale-return', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.returns = response.data.result.return;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        softDeleteproduct(product) {
            const confirmed = window.confirm('Are you sure to delete this returns?');
            if (confirmed) {
                this.loader(true);
                axios.delete('product/' + product.id)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader(false);
                            toastr.success(response.data.message);
                            this.getSaleReturn({ page: 1 });
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
        this.getSaleReturn({ page: 1 });
    }
}
</script>

<style scoped></style>
