<template>
  <div class="card mb-2">
    <div class="card-datatable table-responsive">
      <div class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="row ms-2 me-3">
          <div class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
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
              <th>Pay by</th>
              <th>Paid</th>
              <!-- <th>Subtotal</th>
                          <th>Medicine Dis.</th>
                          <th>Invoice Dis.</th> -->
              <th>discount</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="purchases && purchases.data && purchases.data.length > 0">
              <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(purchase, index) in purchases.data">
                <td class="fw-semibold">
                  {{ purchases.from + index }}
                </td>
                <td>{{ $filters.customFormat(purchase.created_at) }}</td>
                <td class="fw-semibold">
                  {{ purchase.payment_method.name }}
                </td>
                <td class="fw-semibold">
                  {{ purchase.paid }}
                </td>
                <!-- <td class="fw-semibold">
                              {{ purchase.subtotal + purchase.medicine_discount }}
                          </td>
                          <td class="fw-semibold">
                              {{ purchase.medicine_discount }} TK
                          </td>
                          <td class="fw-semibold">
                              {{ purchase.invoice_discount_amount }} <span v-if="purchase.invoice_discount_type === 1">
                                  %</span> <span v-else>TK</span>
                          </td> -->
                <td class="fw-semibold">
                  {{ purchase.discount }}
                </td>
              </tr>
            </template>
            <template v-else>
              <tr>
                <td colspan="6" class="text-center">No invoice Found</td>
              </tr>
            </template>
          </tbody>
        </table>
        <div class="row mx-2">
          <div class="col-sm-12 col-md-6">
            <div class="fw-semibold" role="status" aria-live="polite">
              Showing {{ purchases.from }}
              to {{ purchases.to }} of {{ purchases.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <pagination :data="purchases" :limit="10" :align="'right'"
              @pagination-change-page="getPaginatedPurchase($event)" />
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
  name: 'Customer Sale',
  props: {
    customerId: String // Define the prop for the customer ID
  },
  data() {
    return {
      purchases: {},
      search: '',
      perPage: 10,
      items: [10, 20, 30, 40, 50],
    }
  },
  watch: {
    perPage(perPage) {
      this.getCustomerSale({ page: 1, perPage })
    },
    search: _.debounce(function (search) {
      this.getCustomerSale({ page: 1, search })
    }, 500),
  },
  methods: {
    collect,
    getPaginatedPurchase(page) {
      this.getCustomerSale({ page: page });
      this.scrollToTop();
    },
    getCustomerSale({ page = 1, perPage = this.perPage, search = this.search }) {
      this.loader(true);
      axios.get('/sale-payment', {
        params: {
          page,
          per_page: perPage,
          search,
          customer: this.customerId,
        }
      })
        .then((response) => {
          this.loader(false);
          this.purchases = response.data.result.payment;
        })
        .catch((error) => {
          this.loader(false);
          toastr.error(error.response.data.message);
        })
    },
  },
  mounted() {
    this.getCustomerSale({ page: 1 });
  }
}
</script>

<style scoped>
.action {
  width: 109px;
}
</style>
