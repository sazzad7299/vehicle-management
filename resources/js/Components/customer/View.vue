<template lang="">
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">User / View /</span> Account
            </h4>
            <div class="row">
              <!-- User Sidebar -->
              <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="user-avatar-section">
                      <div class=" d-flex align-items-center flex-column">
                        <img v-if="customer.image != null" class="img-fluid rounded my-4"  height="110" width="110" alt="User avatar" :src="customer.image">
                        <img v-else class="img-fluid rounded my-4"  height="110" width="110" alt="User avatar" src="/images/blank.jpg">
                        <div class="user-info text-center">
                          <h4 class="mb-2">{{ customer.name }}</h4>
                          <span class="badge bg-label-secondary">Customer</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3 text-center">
                      <div>
                          <h5 class="mb-0 ">{{ customer.sales_sum_total }}</h5>
                          <span>Purchase</span>
                        </div>
                        <div>
                          <h5 class="mb-0">{{ customer.sale_payments_sum_paid }}</h5>
                          <span>Paid</span>
                        </div>
                        <div class="text-danger">
                          <h5 class="mb-0">{{ (customer.sales_sum_total - customer.sale_payments_sum_paid) - (customer.sale_return_sum_price -
                                    customer.sale_return_sum_return_amount) }}</h5>
                          <span>Due</span>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                      <ul class="list-unstyled">
                        <li class="mb-3">
                          <span class="fw-medium me-2">Name:</span>
                          <span>{{ customer.name }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Email:</span>
                          <span>{{ customer.email }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Status:</span>
                          <span class="badge bg-label-success" v-if="customer.status =1">Active</span>
                          <span class="badge bg-label-danger" v-else >Active</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Role:</span>
                          <span>Customer</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Contact:</span>
                          <span>{{ customer.phone }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Address:</span>
                          <span>{{ customer.address }}</span>
                        </li>
                      </ul>
                      <div class="d-flex justify-content-center pt-3">
                        <router-link :to="{ name: 'customer.edit', params: { id: customer.id } }">
                                            <button type="button" class="mx-2 btn btn-sm btn-primary hide-arrow">
                                                <i class="bx bx-edit-alt mx-1"></i>
                                            </button>
                                        </router-link>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /User Card -->
              </div>
              <!--/ User Sidebar -->
            
            
              <!-- User Content -->
              <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                <TabMenu @tab-selected="changeTab" />
                <component :is="selectedTabComponent" :customerId="customerId"/>
                <!--/ User Pills -->
              </div>
              <!--/ User Content -->
            </div>
                        
        </div>
    </div>
</template>
<script>
import TabMenu from './TabMenu.vue';
import Billing from './Billing.vue';
import Sale from './Sale.vue';

export default {
  components: {
    TabMenu,
    Billing,
    Sale
  },
  data() {
    return {
      selectedTabComponent: 'Sale',
      customerId: this.$route.params.id,
      customer: {},
    };
  },
  methods: {
    changeTab(tab) {
      this.selectedTabComponent = tab === 'billing' ? 'Billing' : 'Sale';
    },
    customerinfo() {
      axios.get('customer/' + this.customerId)
        .then((response) => {
          this.customer = response.data.result;
          if(this.customer.image != null){
            this.customer.image = '/'+this.customer.image;
          }
           
        })
        .catch((error) => {
          toastr.error(error.response.data.message);
        })
    }
  },
  mounted() {
    this.customerinfo();
  }
};
</script>
<style lang="">
    
</style>