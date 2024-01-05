<template>
    <div class="container flex-grow-1 container-p-y">
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
                                    <label for="payment_method" class="form-label">Employee</label>
                                    <v-select :options="employees" :label="'name'" name="employee_id"
                                        :placeholder="'Select Employee'" :reduce="employee => employee.id"
                                        v-model="unit.employee_id" @update:modelValue="this.allErrors.clear('employee_id')">
                                    </v-select>
                                </div>
                            </div>

                            <div>
                                <button type="button" class="btn btn-outline-secondary" @click="clearData">
                                    clear
                                </button>
                                <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                <button class="btn btn-primary" v-if="salaries.length > 0" @click="print()">Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center border border-success" v-if="salaries.length > 0">
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
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="salaries && salaries.length > 0">
                                    <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(salary, index) in salaries">
                                <td class="fw-semibold">
                                    {{ 1 + index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $filters.MYFormat(salary.month) }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.employee.name }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.employee.phone }}
                                </td>
                                <td class="fw-semibold">
                                    {{ salary.totalPaid }}
                                </td>
                            </tr>
                            <tr>
                                        <td colspan="5" class="fw-semibold text-end">Total Price: {{ totalSalary }} Tk </td>
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
            salaries: [],
            unit: {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
            },
            pharmacy: {},
            currentTime: '',
            filter: {},
            employees:[],
            user: {}
        };
    },
    computed: {

    totalSalary() {
        // Calculate the sum of total for all sales
        return this.salaries.reduce((sum, salary) => sum + salary.totalPaid, 0);
    }
},
    methods: {
        handleSubmit() {
            this.loader(true);
            axios.get('/employee-salary', {
                params: {
                    report: true,
                    to_date: this.unit.to_date,
                    from_date: this.unit.from_date,
                    employee: this.unit.employee_id,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.salaries = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        getEmployee() {
            axios.get('/employee', {
                params: {
                    paginate: false
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.employees = response.data.result;
                    console.log(this.employees);
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
        },
        clearData() {
            this.unit = {
                from_date: this.currentDate(),
                to_date: this.currentDate(),
                employee_id: '',
            };
        },
    },
    mounted() {
        this.getpharmacy();
        this.user = auth.user;
    },
    created(){
        this.getEmployee();
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
