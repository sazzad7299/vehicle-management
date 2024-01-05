<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Plan /</span>My Plan</h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="fw-bold">{{ plan.name }}</h4>
                        <p>{{ plan.description }}</p>
                        <p>Monthly Price:{{ plan.monthly }}</p>
                        <p>Yearly Price : {{ plan.annually }}</p>
                        <p>Expired At : {{ $filters.customFormat(plan.expired_at) }}</p>
                        
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold">Features</h6>
                        <ul class="ps-0 my-4 pt-2 circle-bullets">
                                <li class="mb-2" v-for="feature in plan.features"><i class="bx bx-radio-circle me-2"></i>{{
                                    feature.title }}</li>
                            </ul>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="card">
        <div class="container">
            <h2 class="text-center mb-2">Pricing Plans</h2>
            <p class="text-center mb-4 pb-2"> All plans include 40+ advanced tools and features to boost your product.<br>
                Choose the best plan to fit your needs.</p>
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 pb-5 pt-3 mb-0 mb-md-4">
                <label class="d-flex align-items-center justify-content-center gap-2">
                    <span class="switch-label px-3">Monthly</span>
                    <span class="form-check form-switch form-switch-lg">
                        <input class="form-check-input switch-lg" type="checkbox" v-model="buystatus">
                    </span>
                    <span class="switch-label px-3">Annual</span>
                </label>
                <div class="mt-n5 ms-n5 ml-2 mb-2 d-none d-sm-inline-flex align-items-start">
                    <img :src="pricingarrow" alt="arrow img" class="scaleX-n1-rtl mt-2 pt-1"
                        data-app-dark-img="pages/pricing-arrow-dark.png" data-app-light-img="pages/pricing-arrow-light.png">
                    <span class="badge badge-sm bg-label-primary">Save upto 10%</span>
                </div>
            </div>

            <div class="row mx-0 gy-3 px-lg-5">
                <!-- Pro -->
                <div class="col-lg-4 mb-md-0 mb-4 mx-auto" v-for="(plan, index) in planlist">
                    <div class="card border-primary border shadow-none">
                        <div class="card-body position-relative">
                            <div class="position-absolute end-0 me-4 top-0 mt-4">
                                <span class="badge bg-label-primary">Popular</span>
                            </div>
                            <div class="my-3 pt-2 text-center">
                                <!-- <img src="../../assets/img/icons/unicons/wallet-round.png" alt="Standard Image" height="80"> -->
                            </div>
                            <h3 class="card-title text-center text-capitalize mb-1">{{ plan.name }}</h3>
                            <p class="text-center">{{ plan.description }}</p>
                            <div class="text-center">
                                <div class="d-flex justify-content-center">
                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                    <h1 class="price-toggle price-yearly display-4 text-primary mb-0" v-show="!buystatus">{{
                                        plan.monthly }}</h1>
                                    <h1 class="price-toggle price-monthly display-4 text-primary mb-0" v-show="buystatus">{{
                                        plan.annually }}</h1>
                                    <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal"
                                        v-show="!buystatus">/month</sub>
                                    <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal"
                                        v-show="buystatus">/Yearly</sub>
                                </div>
                                <small class="price-yearly price-yearly-toggle text-muted" v-show="!buystatus">$ {{
                                    plan.annually }} / year</small>
                                <small class="price-yearly price-yearly-toggle text-muted" v-show="buystatus">$ {{
                                    plan.monthly }} / monthly</small>
                            </div>

                            <ul class="ps-0 my-4 pt-2 circle-bullets">
                                <li class="mb-2" v-for="feature in plan.features"><i class="bx bx-radio-circle me-2"></i>{{
                                    feature.title }}</li>
                            </ul>

                            <button v-if="plan.annually > 0 || plan.monthly >0" class="btn btn-primary d-grid w-100" id="sslczPayBtn" @click="handleUpgrade(plan.id)"
                                :postdata="yourPostDataHere" :order="yourOrderHere" endpoint="/pay-via-ajax">
                                Upgrade
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
</template>
<!-- <script src="https://sandbox.sslcommerz.com/embed.min.js"></script> -->
<script>
import { defineComponent } from 'vue'
import _ from "lodash";
import { userStore } from "../../stores/user";

export default defineComponent({
    name: "index",
    data() {
        return {
            plan: {},
            planlist: {},
            buystatus: true,
            pricingarrow: '/images/pricing-arrow-light.png',
            yourPostDataHere: { /* your post data */ },
            cart_json: {
                amount: '',
                status: '',
                userId: '',
            },
            endpoint: "/api/pay-via-ajax",
        }
    },
    methods: {
        handleUpgrade(id) {
            this.cart_json.user = this.user;
            this.cart_json.id = id;
            this.cart_json.amount = 12134124;
            this.cart_json.status = this.buystatus;
            this.setPostdata();
            this.setEndpoint();
            this.initiatePayment();
        },
        setPostdata() {
            const sslczPayBtn = document.getElementById("sslczPayBtn");
            sslczPayBtn.postdata = this.cart_json;
        },
        setEndpoint() {
            const sslczPayBtn = document.getElementById("sslczPayBtn");
            sslczPayBtn.endpoint = this.endpoint;
        },
        initiatePayment() {

            const sslczPayBtn = document.getElementById("sslczPayBtn");
            console.log("Initiating payment with SSLCommerz...");

            const postData = sslczPayBtn.postdata;
            const endpoint = sslczPayBtn.endpoint;

            console.log("Postdata:", postData);
            console.log("Endpoint:", endpoint);

            // Additional logic to initiate payment with SSLCommerz
        },
        getPlan() {
            this.loader(true);
            axios.get('/get-pharmacy-plans')
                .then((response) => {
                    this.loader(false);
                    this.plan = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        },
        planList() {
            axios.get('/plan', { params: { paginate: false } })
                .then((response) => {
                    this.loader(false);
                    this.planlist = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        },
        changeStatus(id) {
            this.loader(true);
            axios.get('/plan/' + id)
                .then((response) => {
                    this.loader(false);
                    toastr.success(response.data.message);
                    this.getPlan({ page: this.plans.current_page });
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        },
    },
    mounted() {
        this.getPlan({ page: 1 });
        this.planList();
        const userInfo = userStore();
        this.cart_json.userId = userInfo.user.id;
    }
})
</script>
<style scoped>
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

li {
    list-style: none;
}
</style>
