<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-center border border-success p-2">
            <div class="col-lg-8 col-md-8 col-sm-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                            <div class="row g-2 mb-3">
                                <template v-if="isCustom">
                                    <div class="col mb-0">
                                        <label for="date" class="form-label">From</label>
                                        <input type="date" class="form-control" v-model="unit.from_date" id="date" />
                                        <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                            v-text="this.allErrors.get('date')">
                                        </span>
                                    </div>
                                    <div class="col mb-0">
                                        <label for="date" class="form-label">To</label>
                                        <input type="date" class="form-control" v-model="unit.to_date" id="date" />
                                        <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                            v-text="this.allErrors.get('date')">
                                        </span>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col mb-0">
                                        <label for="date" class="form-label">Filter</label>
                                        <v-select :options="statics" :label="'title'" name="field_value"
                                            :placeholder="'Select Filter'" :reduce="staticData => staticData.value"
                                            v-model="fixedFilter"></v-select>

                                        <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                            v-text="this.allErrors.get('date')">
                                        </span>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <button type="button" class="btn btn-outline-secondary" @click="clearData">
                                    clear
                                </button>
                                <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                <button class="btn btn-primary" @click="print()">Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center border border-success">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="card" id="invoice">
                    <div class="card-header d-flex justify-content-around">
                        <div class="item text-start">
                            <h4>{{ pharmacy.company_name }}</h4>
                            <p>Mobile:{{ pharmacy.mobile_no }}</p>
                            <p>Address:{{ pharmacy.street_address }}</p>
                            <p>{{ pharmacy.zip_code }}-{{ pharmacy.union_name }}, {{ pharmacy.upazilas_name }} <br> {{
                                pharmacy.union_name }}, {{ pharmacy.upazilas_name }}</p>
                            <br>
                            <p>Data Form: Account Summary <br>
                                {{ $filters.customFormat(unit.from_date) }} to {{ $filters.customFormat(unit.to_date) }}</p>

                        </div>
                        <div class="item">
                            <div>
                                <img :src="'../' + pharmacy.logo" alt class="w-px-200 h-auto rounded-circle" />
                            </div>
                            <p>{{ $filters.customFormat() }} : <Clock></Clock>
                            <p>Issue by:{{ user.name }}</p>
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripe">
                            <tbody class="fw-bold">
                                <tr>
                                    <td>Revenue</td>
                                    <td>:</td>
                                    <td>{{ profits.Revenue }}</td>
                                </tr>
                                <tr>
                                    <td>Sale Profit</td>
                                    <td>:</td>
                                    <td>{{ profits.Profit }}</td>
                                </tr>

                                <tr>
                                    <td>Sale Paid</td>
                                    <td>:</td>
                                    <td>{{ profits.Paid }}</td>
                                </tr>
                                <tr>
                                    <td>Sale Due</td>
                                    <td>:</td>
                                    <td>{{ profits.Due }}</td>
                                </tr>
                                <tr >
                                    <td>Cost</td>
                                    <td>:</td>
                                    <td>{{ profits.Cost }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../errors/errors";

import Clock from "../../clock.vue"


import { userStore } from "../../stores/user";

const auth = userStore();

export default {
    components: {
        Clock
    },
    data() {
        return {
            allErrors: new Errors(),
            profits: [],
            unit: {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
            },
            pharmacy: {},
            currentTime: '',
            filter: {},
            user: {},
            isCustom: true,
            statics: [
                { "id": "1", "title": "Today", "value": "today" },
                { "id": "2", "title": "Last 7 Days", "value": "last7days" },
                { "id": "3", "title": "This Month", "value": "thismonth" },
                { "id": "4", "title": "This Year", "value": "thisyear" },
            ],
            fixedFilter: "today",
        };
    },
    created() {
        this.handleSubmit();
    },
    methods: {
        handleSubmit() {
            this.loader(true);
            axios.get('/report/profit',{
                params:{
                    to_date: this.unit.to_date,
                    from_date: this.unit.from_date,

                }
            })
                .then((response) => {
                    this.loader(false);
                    this.profits = response.data.result.profit;
                    this.filter = response.data.result.filter
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        clearData() {
            this.unit = {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
                stock: '',
            };
        },
        getpharmacy() {
            let id = parseInt(auth.user?.pharmacy_id);
            axios
                .get('/pharmacy/' + id)
                .then((response) => {
                    this.pharmacy = response.data.result;
                })
                .catch((error) => {

                });
        },
        print() {
            const contentToPrint = document.getElementById('invoice');
            const printWindow = window.open('', '', 'width=1200,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title><link rel="stylesheet" href="/backend/assets/vendor/css/core.css" class="template-customizer-core-css"/> <style>body{background:#ffffff!important color:#000000!important;font-family: "Montserrat", sans-serif;}.item p {margin-bottom: 0px;}.datalist{font-size:12px;font-weight:400!important}.table > :not(caption)>*>* {padding: 1px;}</style></head><body>');
            printWindow.document.write('<div style="margin: 20px;">');
            printWindow.document.write(contentToPrint.innerHTML);
            printWindow.document.write('</div><footer class="d-flex justify-content-around fw-semibold"><p>Aurthor Signature</p> <p>Aurthor Signature</p></footer></body></html>');
            printWindow.document.close();
            printWindow.print();
            setTimeout(function () {
                printWindow.close();
            }, 1000);
        }
    },
    mounted() {
        this.pharmacy = auth.user.pharmacy;
        this.user = auth.user;
    },
}
</script>
<style scoped>
.item p {
    margin-bottom: 0px;
}
</style>