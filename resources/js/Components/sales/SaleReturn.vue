<template>
    <div class="modal fade" id="salereturnModal" tabindex="-1" aria-labelledby="paymentCollectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentCollectionModalLabel">Return Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeModal"></button>
                </div>
                <form @submit.prevent="handlePayment" @keydown="allErrors.clear($event.target.name)">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="discount">Date</label>
                            <input type="date" class="form-control" name="date" v-model="date" />
                        </div>
                        <div class="form-group">
                            <label for="discount">Quantity</label>
                            <input type="number" class="form-control" v-model="returnQuantity" name="quantity"
                                :max="Instock" min="0" />
                            <span v-if="this.allErrors.has('quantity')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('quantity')"></span>
                        </div>
                        <div class="form-group">
                            <label for="discount">Medicine Price</label>
                            <input type="number" class="form-control" v-model="amount" readonly />
                        </div>
                        <div class="border border-danger mt-4 p-2" v-if="returnAmount > 0">
                                <span class="text-success">Return Payment</span>
                                <div class="form-group">
                                    <label for="paymentMethod">Payment Method</label>
                                    <select class="form-control" v-model="paymentMethodId">
                                        <option value="" disabled selected>Select Payment Method</option>
                                        <option v-for="method in paymentMethods" :key="method.id" :value="method.id">{{
                                            method.name
                                        }}</option>
                                    </select>
                                    <span v-if="this.allErrors.has('payment_method_id')"
                                        class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('payment_method_id')"></span>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Amout</label>
                                    <input type="number" class="form-control" v-model="returnAmount" name="quantity"  readonly/>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';
export default {
    props: {
        detailId: {
            type: String,
            required: true
        },
        Instock: {
            type: Number,
            required: true
        },
        quantity: {
            type: Number,
            required: true
        },
        total: {
            type: Number,
            required: true
        },
        paymentMethods: {
            type: Object,
            required: true,
        },
        due: {
            type: Number,
            required: true,
        },
        customer: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
            returnQuantity: 0,
            paymentMethodId: '',
            returnAmount: 0,
            amount: 0,
            date: this.currentDate(),
            allErrors: new Errors(),
        }
    },
    watch: {
        returnQuantity(newValue) {
            this.amount = this.updatedAmount;
        }
    },
    methods: {
        handlePayment() {
            this.loader(true);
            const data = {
                detail_id: this.detailId,
                payment_method_id: this.paymentMethodId,
                returnAmount: this.returnAmount,
                quantity: this.returnQuantity,
                price: this.amount,
                date: this.date,
                customer_id: this.customer,
            };
            axios.post("sale-return", data)
                .then((response) => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.$emit('return-success');
                    $('#salereturnModal').modal('hide');
                    this.clearData()
                })
                .catch((error) => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                });

        },
        closeModal() {
            this.$emit('close');
            this.clearData();
        },
        clearData() {
            this.returnQuantity = 0;
            this.paymentMethodId = '';
            this.returnAmount = 0;
            this.amount = 0;
            this.date = this.currentDate();
        }

    },
    computed: {
        updatedAmount() {
            const total = parseFloat(this.total);
            if (this.returnQuantity > this.Instock) {
                this.returnQuantity = this.Instock;

                toastr.warning(`Maximum Return ${this.Instock} quantity`);
            };

            const quantity = parseInt(this.quantity);
            const returnQuantity = parseInt(this.returnQuantity);
            this.amount = Math.round(total / quantity * returnQuantity);
            if (this.amount > this.due) {
                this.returnAmount = this.amount - this.due;
            };
            return this.amount;

        }
    }
};
</script>

<style>
</style>
