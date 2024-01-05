<template>
    <div>
      <div class="row border border-success p-2">
        <div class="col-lg-3 col-md-3 col-sm-12 mb-4" v-for="data in summary">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <!-- <div class="avatar flex-shrink-0">
                  <i class="menu-icon tf-icons bx bx-check-shield bx-lg"></i>
                </div> -->
              </div>
              <span class="fw-semibold d-block mb-1">{{ data.name }}</span>
              <h3 class="card-title mb-2">{{ data.amount }}</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
          <div class="card">
            <div class="card-body current-balance">
              <h4 class="text-success">Current Balance</h4>
              <h5 v-for="item in balance">{{ item.name }} : {{ item.current_balance }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        summary: [],
        balance: [],
      };
    },
    methods: {
      report() {
        this.loader(true);
        axios
          .get('report/summary')
          .then((response) => {
            this.loader(false);
            this.summary = response.data.result;
            this.currentBalance();
          })
          .catch((error) => {
            this.loader(false);
            console.error('Error in report API:', error);
            toastr.error(error.response ? error.response.data.message : 'An error occurred');
          });
      },
      currentBalance() {
        axios
          .get("/current-balance")
          .then((response) => {
            this.loader(false);
            this.balance = response.data.result;
          })
          .catch((error) => {
            this.loader(false);
            console.error('Error in currentBalance API:', error);
            toastr.error(error.response ? error.response.data.message : 'An error occurred');
          });
      },
      loader(show) {
        // Implement your loader logic here (if applicable)
      },
    },
    created() {
      this.report();
    },
  };
  </script>
  
  <style scoped>
  /* Add your component-specific CSS styling here */
  </style>
  