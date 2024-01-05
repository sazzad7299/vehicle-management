<template>
    <div class="container-xxl flex-grow-1 container-p-y" v-if="hasPermission('dashboard')">
        <span v-if="isLoading">Loading Summary...</span>
            <Summary v-else :summaryData="summaryData"/>
        <div class="row">
            <Stockout v-if="!isLoadingStockout && stockoutData.length > 0" :stockoutData="stockoutData" />
            <Expire v-if="!isLoadingExpire && expireData?.data?.length > 0" :expireData="expireData" />
        </div>
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span v-if="isLoadingMonthly">Loarding Data</span>
                        <Doublebarchart v-else :yearlyData="yearlyData"></Doublebarchart>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 bg-white box-shadow rounded-3" width="100">
                <div class="card-body" v-if="isLoading">
                    Loarding .....
                </div>
                <div class="card-body"  v-else>
                    <PieChart :summaryData="summaryData"></PieChart>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span v-if="isLoadingMonthly">Loarding Data</span>
                        <AreaChart v-else :yearlyData="yearlyData"></AreaChart>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 px-1">
                <div class="card">
                    <div class="card-body ">
                        <span v-if="isLoading">Loarding Data</span>
                        <barchart v-else :balance="currentBalance"></barchart>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>
  
<script>
import Summary from './Summary.vue';
import Stockout from './Stockout.vue';
import Expire from './Expire.vue';
import barchart from '../charts/barchart.vue';
import Doublebarchart from '../charts/doublebarchart.vue';
import AreaChart from '../charts/areachart.vue';
import PieChart from '../charts/piechart.vue';
export default {
    components: {
        Summary,
        Stockout,
        Expire,
        barchart,
        Doublebarchart,
        AreaChart,
        PieChart,
    },
    data() {
        return {
            isLoading: true,
            isLoadingStockout: false,
            isLoadingExpire: false,
            summaryData: [],
            currentBalance: [],
            isLoadingMonthly:true,
            stockoutData: [],
            expireData: [],
            yearlyData:[],
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        };
    },
    watch: {
        perPage(perPage) {
            this.fetchStockoutData({ page: 1, perPage });
        },

    },
    methods: {
        async fetchData() {
            try {
                // Fetch summary data from an API
                this.summaryData = await this.fetchSummaryData();

                // Fetch current balance based on summary data
                this.currentBalance = await this.fetchCurrentBalance(this.summaryData);

                // Fetch stockout data based on current balance
                this.stockoutData = await this.fetchStockoutData(this.currentBalance);

                // Fetch expire data based on summary data or any other logic
                this.expireData = await this.fetchExpireData(this.summaryData);

                // All data loaded
                this.isLoading = false;
                this.isLoadingStockout = false;
                this.isLoadingExpire = false;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        async fetchSummaryData() {
            return new Promise((resolve, reject) => {
                axios
                    .get('report/summary')
                    .then((response) => {
                        this.summaryData = response.data.result;
                        resolve(this.summaryData);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async fetchCurrentBalance(summaryData) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/current-balance")
                    .then((response) => {
                        this.currentBalance = response.data.result;

                        resolve(this.currentBalance);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async fetchStockoutData(summaryData, page = 1, perPage = 10) {
            try {
                const response = await axios.get("/report/stocks", {
                    params: {
                        page,
                        per_page: perPage,
                        stock: 'out'
                    },
                });
                this.stockoutData = response.data.result.stock;
                return this.stockoutData;
            } catch (error) {
                throw error;
            }
        },
        async fetchExpireData(summaryData) {
            this.isLoadingExpire = true;
            return new Promise((resolve, reject) => {
                axios
                    .get("/report/expired")
                    .then((response) => {
                        this.expireData = response.data.result;
                        resolve(this.expireData);
                        console.log(this.expireData);
                        this.isLoadingExpire = false;
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
         getSaleTotals() {
            this.isLoadingMonthly = true
            axios
                .get('/report/yearly-sale')
                .then((response) => {
                    this.yearlyData = response.data.result;
                    this.isLoadingMonthly= false;
                })
                .catch((error) => {
                    // handleErrorResponse.call(this, error);
                });
        },
    },
    created() {
        this.fetchData();
        this.getSaleTotals();
    }
};
</script>
  