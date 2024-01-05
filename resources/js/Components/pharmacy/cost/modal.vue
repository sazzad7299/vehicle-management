<template>
    <div class="modal " v-if="isOpen">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ mode === 'add' ? 'Add Cost' : 'Edit Cost' }}
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" @click="closeModal"></button>
                </div>
                <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-0">
                                <label for="nameSmall" class="form-label">Name <span class="required">*</span></label>
                                <input type="name" class="form-control" v-model="unit.name" />
                                <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('name')">
                                </span>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="nameSmall" class="form-label">Date<span class="required">*</span></label>
                                <input type="date" class="form-control" v-model="unit.date" />
                                <span v-if="this.allErrors.has('date')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('date')">
                                </span>
                            </div>
                            <div class="col mb-0">
                                <label for="payment_method" class="form-label">Payment Method<span class="required">*</span></label>
                                <select name="payment_method" v-model="unit.payment_method_id" required class="form-control"
                                    @change="updateCurrentBalance">
                                    <option value="" selected>Select Account</option>
                                    <option v-for="(method, index) in paymentMethods" :key="index" :value="method.id">{{
                                        method.name }}</option>
                                        <span v-if="this.allErrors.has('payment_method_id')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('payment_method_id')">
                                </span>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="nameSmall" class="form-label">Current Balance</label>
                                <input type="text" class="form-control" id="currentBalance" :value="unit.current_balance"
                                    readonly />

                            </div>
                            <div class="col mb-0">
                                <label class="form-label" for="emailSmall">Amount<span class="required">*</span></label>
                                <input type="number" class="form-control" id="emailSmall" placeholder="Notes"
                                    v-model="unit.amount" name="amount" />
                                <span v-if="this.allErrors.has('amount')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('amount')">
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="emailSmall">Notes</label>
                                <input type="text" class="form-control" placeholder="Notes" v-model="unit.note"
                                    name="note"/>
                                <span v-if="this.allErrors.has('note')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('note')">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" @click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ mode === 'add' ? 'Add' : 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
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
        unitData: Object,
        methoddata: Object,
    },
    data() {
        return {
            allErrors: new Errors(),
            unit: {
                name:'',
                payment_method_id: '',
                current_balance: 0,
                date: "",
                note: "",
                amount: 0,
            },
            paymentMethods: [],
        };
    },
    computed: {

    },
    watch: {
        unitData: {
            immediate: true,
            handler(newVal) {
                if (this.mode === 'edit' && newVal) {
                    this.unit = { ...newVal }; // Copy the unitData object to the unit data property
                }
            }
        },
        methoddata: {
            immediate: true,
            handler(newVal) {
                this.paymentMethods = newVal;
            }
        },
        'unit.amount': function (newVal) {
            this.handleAmountExceedingBalance();
        }
    },
    methods: {
        handleSubmit() {
            if (this.mode === 'add') {
                this.loader(true);
                axios.post('cost', { ...this.unit })
                    .then(response => {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.clearData()
                        // this.fetchPaymentMethods();
                        this.$emit('typeAdded');

                    })
                    .catch(error => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            } else if (this.mode === 'edit') {
                axios
                    .put(`cost/${this.unit.id}`, { ...this.unit })
                    .then((response) => {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.$emit('typeAdded');
                    })
                    .catch((error) => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
        closeModal() {
            this.$emit('close');
            this.clearData();
        },
        clearData() {
            this.unit = {
                type: 1,
                payment_method_id: '',
                amount: 0,
                note: '',
                date: this.currentDate(),
            }
        },
        updateCurrentBalance() {
            const selectedMethodId = this.unit.payment_method_id;
            const method = this.paymentMethods.find((m) => m.id === selectedMethodId);
            console.log
            if (method) {
                this.unit.current_balance = method.current_balance;
            }
        },
        handleAmountExceedingBalance() {
            if (parseFloat(this.unit.amount) > parseFloat(this.unit.current_balance)) {
                toastr.warning('Cost Amount not getter then Current Balance');
                this.unit.amount = this.unit.current_balance;
            }
        }
    },
    mounted() {
        this.unit.date = this.currentDate();
        if(this.mode === 'edit'){
           this.updateCurrentBalance(); 
        }
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

</style>
