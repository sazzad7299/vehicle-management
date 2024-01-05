<template >
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Medicines /</span>Stock List</h4>
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
                          <th>Barcode</th>
                          <th>Name</th>
                          <th>Generic</th>
                          <th>Expire At</th>
                          <th>Stock</th>
                          <th>Stock Price</th>
                      </tr>
                      </thead>
                      <tbody>
                          

                                <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(stock, index) in stocks.data">
                                <td>{{ stocks.from + index }}</td>
                                <td>{{ stock.medicine.barcode }}</td>
                                <td>{{ stock.medicine.name }}</td>
                                <td>{{ stock.medicine.generic }}</td>
                                <td>{{ $filters.customFormat(stock.expire_date) }}</td>
                                <td>{{ stock.total_qty }}</td>
                                <td>{{ stock.stock_price }} Tk</td>
                            </tr>
                     
                      </tbody>
                    </table>
                  
                  <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ stocks.from }}
                                to {{ stocks.to }} of {{ stocks.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="stocks" :limit="10" :align="'right'"
                                        @pagination-change-page="fetchstocks($event)"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import _ from "lodash";
export default {
    name: 'Stock List',
    data() {
        return {
            stocks: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getStock({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getStock({ page: 1, search })
        }, 500),
    },
    methods: {
        getPaginatedStock(page) {
            this.getStock({ page: page });
            this.scrollToTop();
        },
        getStock({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/report/stocks', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                    stock:'in',
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.stocks = response.data.result.stock;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
    },

    mounted() {
        this.getStock({ page: 1 });
    }
}
</script>
<style lang="">
    
</style>