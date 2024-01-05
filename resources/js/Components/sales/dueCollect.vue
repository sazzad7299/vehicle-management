<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light"><router-link :to="{ name: 'sale.index' }">Sale</router-link> /</span>Customer Due
      collect
    </h4>
    <div class="card container-p-y">
      <h5 class="card-header fw-bold">Customer Wise Due Collect</h5>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <form @submit.prevent="dueCollect">
              <div class="mb-3 col-md-12">
                <label class="form-label" for="basic-default-name">Select Customer<span class="text-danger">*</span>
                </label>
                <v-select :options="customers" :label="'phone'" name="customer_id" :placeholder="'Select Customer'"
                  :reduce="(customer) => customer.id" v-model="form.customer_id"></v-select>
              </div>
              <template v-if="customerDue > 0">
                <div class="mb-3 col-md-12">
                  <label class="form-label" for="basic-default-name">Select Payment Account<span
                      class="text-danger">*</span>
                  </label>
                  <v-select :options="paymentMethods" :label="'name'" name="method_id"
                    :placeholder="'Select Payment Account'" :reduce="(paymentMethod) => paymentMethod.id"
                    v-model="form.payment_method_id"></v-select>
                </div>
                <div class="mb-3 col-md-12">
                  <label class="form-label" for="basic-default-name">Paid Amount<span class="text-danger">*</span>
                  </label>
                  <input type="number" v-model="form.paid" class="form-control">
                </div>
                <div class="mb-3 col-md-12">
                  <button class="btn btn-dark mx-auto"> Submit</button>
                </div>
              </template>

              <div class="mb-3 col-md-12" v-else>
                <p>This cutomer no due available</p>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="card-body border border-1 border-solid border-success" v-if="customer !== null">
              <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                  <img v-if="customer.image != null" class="img-fluid rounded my-4" height="110" width="110"
                    alt="User avatar" :src="customer.image" />
                  <img v-else class="img-fluid rounded my-4" height="110" width="110" alt="User avatar"
                    src="/images/blank.jpg" />
                  <div class="user-info text-center">
                    <h4 class="mb-2">{{ customer.name }}</h4>
                    <span class="badge bg-label-secondary">Customer <router-link
                        :to="{ name: 'customer.view', params: { id: customer.id } }"
                        v-if="hasPermission('customer.view')">
                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                          <i class='bx bxs-bullseye'></i>
                        </button>
                      </router-link></span>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-around flex-wrap my-4 py-3 text-center">
                <div>
                  <h5 class="mb-0">
                    {{
                      customer.sales_sum_total != null
                      ? customer.sales_sum_total
                      : 0
                    }}
                  </h5>
                  <span>Purchase</span>
                </div>
                <div>
                  <h5 class="mb-0">
                    {{
                      customer.sale_payments_sum_paid != null
                      ? customer.sale_payments_sum_paid
                      : 0
                    }}
                  </h5>
                  <span>Paid</span>
                </div>
                <div>
                  <h5 class="mb-0">
                    {{
                      customer.sale_return_sum_price -
                          customer.sale_return_sum_return_amount
                    }}
                  </h5>
                  <span>Due Return</span>
                </div>
                <div class="text-danger">
                  <h5 class="mb-0">
                    {{
                      (customerDue =
                        customer.sales_sum_total -
                        customer.sale_payments_sum_paid -
                        (customer.sale_return_sum_price -
                          customer.sale_return_sum_return_amount))
                    }}
                  </h5>
                  <span>Due</span>
                </div>
              </div>
              <h5 class="pb-2 border-bottom">Details</h5>
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mb-1">
                    <span class="fw-medium me-2">Name:</span>
                    <span>{{ customer.name }}</span>
                  </li>
                  <li class="mb-1">
                    <span class="fw-medium me-2">Email:</span>
                    <span>{{ customer.email }}</span>
                  </li>
                  <li class="mb-1">
                    <span class="fw-medium me-2">Status:</span>
                    <span class="badge bg-label-success" v-if="(customer.status = 1)">Active</span>
                    <span class="badge bg-label-danger" v-else>Active</span>
                  </li>
                  <li class="mb-1">
                    <span class="fw-medium me-2">Role:</span>
                    <span>Customer</span>
                  </li>
                  <li class="mb-1">
                    <span class="fw-medium me-2">Contact:</span>
                    <span>{{ customer.phone }}</span>
                  </li>
                  <li class="mb-3">
                    <span class="fw-medium me-2">Address:</span>
                    <span>{{ customer.address }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { handleErrorResponse } from "../../errors/errorHandler.js";
import { handleSuccessResponse } from "../../errors/successHandler.js";
export default {
  data() {
    return {
      customers: [],
      customerId: null,
      customer: {},
      customerDue: 0,
      paymentMethods: [],
      form: {
        customer_id: null,
        payment_method_id: null,
        paid: 0,
      },
    };
  },
  watch: {
    "form.customer_id": function (val, oldval) {
      if (val > 0) {
        this.getCustomerData();
      }
    },
    "form.paid": function (newValue, oldval) {
      if (newValue > this.customerDue) {
        toastr.error("Paid Amount not getter then Due amount");
        this.form.paid = this.customerDue;
      }
    },
  },
  methods: {
    getCustomers() {
      axios
        .get("/customer", { params: { paginate: true } })
        .then((response) => {
          this.customers = response.data.result;
        })
        .catch((error) => {
          handleErrorResponse.call(this, error);
        });
    },
    getCustomerData() {
      axios
        .get("customer/" + this.form.customer_id)
        .then((response) => {
          this.customer = response.data.result;
          if (this.customer.image != null) {
            this.customer.image = "/" + this.customer.image;
          }
        })
        .catch((error) => {
          toastr.error(error.response.data.message);
        });
    },
    getPaymentMethods() {
      axios
        .get("/payment-method", { params: { paginate: true } })
        .then((response) => {
          this.paymentMethods = response.data.result;
        })
        .catch((error) => {
          handleErrorResponse.call(this, error);
        });
    },
    dueCollect() {
      this.loader(true);
      axios
        .post("/customer-due-collect", this.form)
        .then(response => {
          this.loader(false);
          handleSuccessResponse.call(this, response);
          this.getCustomerData();
          this.form.paid = 0;
        })
        .catch(error => {
          this.loader(false);
          handleErrorResponse.call(this, error);
        })
    }
  },
  created() {
    this.getCustomers();
    this.customer = null;
    this.getPaymentMethods();
  },
};
</script>

<style></style>
