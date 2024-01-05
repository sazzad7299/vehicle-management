<template>
    <div class="modal col-md-12" v-if="isOpen">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ mode === 'add' ? 'Add Salary' : 'Edit Cash In/Out' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeModal"></button>
                </div>
                <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="nameWithTitle" class="form-label">Employee</label>
                                <v-select :options="employees" :label="'name'" name="employee_id"
                                    :placeholder="'Select Employee'" :reduce="employee => employee.id"
                                    v-model="form.employee_id"></v-select>
                                <span v-if="this.allErrors.has('employee_id')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('employee_id')">
                                </span>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label for="nameWithTitle" class="form-label">Date</label>
                                <input type="date" class="form-control" v-model="form.date">
                                <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('date')">
                                </span>
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label for="paid" class="form-label">Salary</label>
                                <input type="number" id="paid" class="form-control" placeholder="Amount" v-model="salary"
                                    readonly />
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label for="paid" class="form-label">Payable</label>
                                <input type="number" id="paid" class="form-control" placeholder="Salary" v-model="payable"
                                    readonly />
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label for="paid" class="form-label">Paid</label>
                                <input type="number" id="paid" class="form-control" placeholder="Salary"
                                    v-model="form.paid" />
                                <span v-if="this.allErrors.has('paid')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('paid')">
                                </span>
                            </div>

                            <div class="col-md-3 col-sm-12 mb-3">
                                <label for="emailWithTitle" class="form-label">Pay By</label>
                                <v-select :options="paymentMethods" :label="'name'" name="payment_method_id"
                                    :placeholder="'Select Account'" :reduce="method => method.id"
                                    v-model="form.payment_method_id"></v-select>
                                <span v-if="this.allErrors.has('payment_method_id')"
                                    class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('payment_method_id')">
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" @click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ mode === 'add' ? 'Save' : 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
    props: {
        isOpen: Boolean,
        mode: {
            type: String,
            default: 'add' // 'add' or 'edit'
        },
        methoddata: Object,
    },
    data() {
        return {
            allErrors: new Errors(),
            employees: [],
            paymentMethods: [],
            form: {
                date: new Date().toISOString().substr(0, 10),
                employee_id:null
            },
            salary: 0,
            payable: 0
        };
    },
    computed: {

    },
    watch: {
        'form.employee_id': function (newemployeeId, oldStaffId) {
            const selectedEmployee = this.employees.find(employee => employee.id === newemployeeId);

            if (selectedEmployee) {
                this.salary = selectedEmployee.salary;
                this.getpaid();
            } else {
                this.salary = 0;
            }
        },
        'form.date': function (newDate, oldDate) {
            this.getpaid();
        },
        'form.paid': function (newPaid, oldDate) {
            this.validadvance(newPaid);
        }
    },
    methods: {
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
        handleSubmit() {
            console.log(this.form);
            axios.post('/employee-salary', this.form)
                .then((response) => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.closeModal();
                    this.$emit('salaryPaid');
                })
                .catch((error) => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        closeModal() {
            this.$emit('close');
            this.clearData();
        },
        clearData() {
            this.form = {
                date: new Date().toISOString().substr(0, 10),
                employee_id:null
            }
            this.payable = 0;
            this.salary =0;
        },
        getPaymentMethods() {
            axios
                .get('/payment-method', { params: { paginate: true } })
                .then((response) => {
                    this.paymentMethods = response.data.result;
                    const cash = this.paymentMethods.find(account => account.name === 'Cash');
                    if (cash) {
                        this.salary.payment_method_id = cash.id;
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        validadvance(value) {

            if (value > this.payable || value < 0) {
                toastr.warning("You can't pay more then " + this.payable);
                this.form.paid = this.payable;
            }
        },
        getpaid() {
            axios
                .get(`/get-paid-salary/${this.form.employee_id}/${this.form.date}`)
                .then((response) => {
                    const paid = response.data.result;
                    const payable = this.salary - paid;
                    this.payable = payable;
                    const cash = this.paymentMethods.find(account => account.name === 'Cash');
                    if (cash) {
                        this.salary.payment_method_id = cash.id;
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        }
    },
    created() {
        this.getEmployee();
        this.getPaymentMethods();
    },
};
</script>

<style scoped>
/* Styles for the modal */
.modal {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100% !important;
}

.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

.modal-dialog.modal-lg {
    width: 80%;
}</style>
