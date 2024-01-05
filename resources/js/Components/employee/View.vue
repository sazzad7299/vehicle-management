<template lang="">
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">Employee / View /</span> Account
            </h4>
            <div class="row">
              <!-- User Sidebar -->
              <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="user-avatar-section">
                      <div class=" d-flex align-items-center flex-column">
                        <img v-if="employee.image != null" class="img-fluid rounded my-4"  height="110" width="110" alt="User avatar" :src="employee.image">
                        <img v-else class="img-fluid rounded my-4"  height="110" width="110" alt="User avatar" src="/images/blank.jpg">
                        <div class="user-info text-center">
                          <h4 class="mb-2">{{ employee.name }}</h4>
                          <span class="badge bg-label-secondary">Employee</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3 text-center">
                        <!-- <div>
                          <h5 class="mb-0 ">{{ employee.sales_sum_total }}</h5>
                          <span>Purchase</span>
                        </div>
                        <div>
                          <h5 class="mb-0">{{ employee.sale_payments_sum_paid }}</h5>
                          <span>Paid</span>
                        </div>
                        <div class="text-danger">
                          <h5 class="mb-0">{{ (employee.sales_sum_total - employee.sale_payments_sum_paid) - (employee.sale_return_sum_price -
                                    employee.sale_return_sum_return_amount) }}</h5>
                          <span>Due</span>
                        </div> -->
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                      <ul class="list-unstyled">
                        <li class="mb-3">
                          <span class="fw-medium me-2">Name:</span>
                          <span>{{ employee.name }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Email:</span>
                          <span>{{ employee.email }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Status:</span>
                          <span class="badge bg-label-success" v-if="employee.status =1">Active</span>
                          <span class="badge bg-label-danger" v-else >Active</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Designation:</span>
                          <span>{{ employee.place }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Contact:</span>
                          <span>{{ employee.phone }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-medium me-2">Address:</span>
                          <span>{{ employee.street_address }}</span>
                        </li>
                      </ul>
                      <div class="d-flex justify-content-center pt-3">
                        <router-link :to="{ name: 'employee.edit', params: { id: employee.id } }">
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
              <!-- <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <TabMenu @tab-selected="changeTab" />
                <component :is="selectedTabComponent" :employeeId="employeeId"/>
              </div> -->
              <!--/ User Content -->
            </div>
                        
        </div>
    </div>
</template>
<script>
// import TabMenu from './TabMenu.vue';
// import Billing from './Billing.vue';
// import Sale from './Sale.vue';

export default {
  // components: {
  //   TabMenu,
  //   Billing,
  //   Sale
  // },
  data() {
    return {
      selectedTabComponent: 'Sale',
      employeeId: this.$route.params.id,
      employee: {},
    };
  },
  methods: {
    changeTab(tab) {
      this.selectedTabComponent = tab === 'billing' ? 'Billing' : 'Sale';
    },
    employeeinfo() {
      axios.get('employee/' + this.employeeId)
        .then((response) => {
          this.employee = response.data.result;
          if (this.employee.image != null) {
            this.employee.image = '/' + this.employee.image;
          }

        })
        .catch((error) => {
          toastr.error(error.response.data.message);
        })
    }
  },
  mounted() {
    this.employeeinfo();
  }
};
</script>
<style lang="">
    
</style>