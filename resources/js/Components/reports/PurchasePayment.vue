<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-center border border-success p-2">
            <div class="col-lg-8 col-md-8 col-sm-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                            <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                    <label for="date" class="form-label">From Date</label>
                                    <input type="date" class="form-control" v-model="unit.from_date" id="date" />
                                    <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('date')">
                                    </span>
                                </div>
                                <div class="col mb-0">
                                    <label for="date" class="form-label">To Date</label>
                                    <input type="date" class="form-control" v-model="unit.to_date" id="date" />
                                    <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('date')">
                                    </span>
                                </div>
                                <div class="col mb-0">
                                    <label for="payment_method" class="form-label">Supplier</label>
                                    <v-select :options="suppliers" :label="'name'" name="supplier_id"
                                        :placeholder="'Select supplier'" :reduce="supplier => supplier.id"
                                        v-model="unit.supplier_id" @update:modelValue="this.allErrors.clear('supplier_id')">
                                    </v-select>
                                </div>
                            </div>

                            <div>
                                <button type="button" class="btn btn-outline-secondary" @click="clearData">
                                    clear
                                </button>
                                <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                <button class="btn btn-primary" v-if="payments.length > 0" @click="print()">Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center border border-success" v-if="payments.length > 0">
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
                            <p>Data Form: Purchase Payment <br>{{ $filters.customFormat(filter.from_date) }} to {{
                                $filters.customFormat(filter.to_date) }}</p>


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
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>pay by</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody class="datalist">
                                <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(payment, index) in payments">
                                    <td class="fw-semibold">
                                        {{ 1 + index }}
                                    </td>
                                    <td>
                                        {{ $filters.customFormat(payment.created_at) }}
                                    </td>
                                    <td>
                                        {{ payment.supplier_name }}
                                    </td>
                                    <td>{{ payment.payment_method.name }}</td>
                                    <td>
                                        {{ payment.paid }}
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td colspan="3" class="fw-semibold">Total Quantity: {{ totalQuantitySum }} </td> -->
                                    <td colspan="5" class="fw-semibold">Total Paid: {{ totalSum }} Tk </td>
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
            payments: {},
            unit: {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
                supplier_id: '',
            },
            suppliers: [],
            pharmacy: {},
            currentTime: '',
            filter: {},
            user: {}
        };
    },
    methods: {
        handleSubmit() {
            this.loader(true);

            axios.get('/purchase-payment', {
                params: {
                    to_date: this.unit.to_date,
                    from_date: this.unit.from_date,
                    supplier: this.unit.supplier_id,
                    paginate: false
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.payments = response.data.result.payment;
                    this.filter = response.data.result.filter
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        supplier() {
            axios
                .get('/supplier', { params: { paginate: true } })
                .then((response) => {
                    this.suppliers = response.data.result;
                })
                .catch((error) => {

                });
        },
        clearData() {
            this.unit = {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
                supplier_id: '',
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
    computed: {
        // totalQuantitySum() {
        //     // Calculate the sum of total_quantity for all sales
        //     return this.payments.reduce((sum, purchase) => sum + purchase.total_quantity, 0);
        // },
        totalSum() {
            // Calculate the sum of total for all sales
            return this.payments.reduce((sum, purchase) => sum + purchase.paid, 0);
        },
    },
    mounted() {
        this.supplier();
        this.getpharmacy();
        this.user = auth.user;
    }
}
</script>
<style scoped>
.item p {
    margin-bottom: 0px;
}
</style>