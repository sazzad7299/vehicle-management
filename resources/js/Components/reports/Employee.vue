<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-center border border-success">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <button class="btn btn-primary print" @click="print()">Print</button>
                <div class="card" id="invoice">
                    <div class="card-header d-flex justify-content-around">
                        <div class="item text-start">
                            <h4>{{ pharmacy.company_name }}</h4>
                            <p>Mobile:{{ pharmacy.mobile_no }}</p>
                            <p>Address:{{ pharmacy.street_address }}</p>
                            <p>{{ pharmacy.zip_code }}-{{ pharmacy.union_name }}, {{ pharmacy.upazilas_name }} <br> {{
                                pharmacy.union_name }}, {{ pharmacy.upazilas_name }}</p>
                            <br>
                            <p>Data Form: Customers</p>

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
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th>Joining</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="customers && customers.length > 0">
                                    <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(customer, index) in customers">
                                        <td class="fw-semibold">
                                            {{ 1 + index }}
                                        </td>
                                        <td class="fw-semibold">
                                            {{ customer.name }}
                                        </td>
                                        <td class="fw-semibold">
                                            {{ customer.phone }}
                                        </td>
                                        <td class="fw-semibold">
                                            {{ customer.email }}
                                        </td>
                                        <td class="fw-semibold">
                                            {{ $filters.customFormat(customer.joining_date) }}
                                        </td>
                                        <td class="fw-semibold">
                                            {{ customer.salary }}
                                        </td>
                                        <td class="fw-semibold">
                                            <span class="badge bg-success"
                                                :class="customer.status == 1 ? 'bg-success' : 'bg-dark'">{{ customer.status
                                                    == 1 ?
                                                    'Active' : 'Inactive' }}</span>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan="6" class="text-center">No Data Found</td>
                                    </tr>
                                </template>
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
            customers: [],
            unit: {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
            },
            pharmacy: {},
            currentTime: '',
            filter: {},
            user: {}
        };
    },
    created() {
        this.handleSubmit();
    },
    methods: {
        handleSubmit() {
            this.loader(true);
            axios.get('/employee', {
                params: {
                    report: true
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.customers = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
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
        this.getpharmacy();
        this.user = auth.user;
    }
}
</script>
<style scoped>
.print {
    position: absolute;
    z-index: 1;
    right: 5rem;
}

.item p {
    margin-bottom: 0px;
}
</style>
