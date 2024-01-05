<template lang="">
        <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic">
            <div class="authentication-inner ">
                <div class="card">
                    <div class="card-body">
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
                                <img :src="asset('backend/assets/img/illustrations/pricing-arrow.png')">
                                <span class="badge badge-sm bg-label-primary">Save upto 10%</span>
                            </div>
                        </div>
                        <div class="row mx-0 gy-3 px-lg-5">
                            <!-- Pro -->
                            <div class="col-lg-4 mb-md-0 mb-4 mx-auto" v-for="(plan, index) in planlist">
                                <div class="card border-primary border shadow">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary">Popular</span>
                                        </div>
                                        <div class="my-3 pt-2 text-center">
                                        <!-- // <img src="../../assets/img/icons/unicons/wallet-round.png" alt="Standard Image" height="80"> -->
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

                                        <button class="btn btn-primary d-grid w-100" id="sslczPayBtn" @click="handleUpgrade(plan.id)"
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
        </div>
        </div>
</template>
<script>
import { userStore } from "../../stores/user";
export default {
    data() {
        return {
            planlist: {},
            status: null,
            statuses: [
                { value: 1, name: 'Active' },
                { value: 2, name: 'Inactive' },
            ],
            buystatus: true,
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
    },
    mounted() {
        this.planList();
        const userInfo = userStore();
        this.cart_json.userId = userInfo.user.id;
    }
}
</script>
<style scoped>
.authentication-inner{
    max-width: 1200px!important;
}
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

li {
    list-style: none;
}
</style>