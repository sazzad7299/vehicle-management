<template>
    <div>
        <div class="card">
            <div class="row ms-2 me-3 mt-4 mb-4">
                <div
                    class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                    <h4>Purchase Medicine</h4>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row">
                    <div class="col-md-6">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                    class="bx bx-user"></i></span>
                            <v-select :options="suppliers" :label="'name'" name="supplier_id" :class="'col-md-8'"
                                :placeholder="'Select Supplier'" :reduce="supplier => supplier.id"
                                v-model="purchase.supplier_id" @update:modelValue="this.allErrors.clear('supplier_id')">
                            </v-select>
                        </div>
                        <span v-if="this.allErrors.has('purchase.supplier_id')" class="error text-danger fw-semibold mt-3"
                            v-text="this.allErrors.get('purchase.supplier_id')"></span>
                    </div>
                    <div class="dataTables_filter col-md-6">
                        <label>
                            <input type="number" class="form-control" placeholder="Barcode" name="medicine_barcode"
                                v-model="medicine_barcode" aria-controls="DataTables_Table_0">
                        </label>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap px-md-3" v-if="purchaseProducts.length > 0">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>#SN</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Expire</th>
                            <th>P.P</th>
                            <th>M.R.P</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Dis(%)</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in purchaseProducts" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>
                                <input type="hidden" v-model="product.id">
                                <input v-model="product.barcode" type="text" readonly />
                            </td>
                            <td><input v-model="product.name" type="text" readonly /></td>
                            <td class="fillable px-2"><input
                                    :class="{ 'bg-red': allErrors.has('purchaseProducts.' + index + '.expire_date') }"
                                    v-model="product.expire_date" type="date" /></td>
                            <td class="fillable px-2"><input v-model="product.pp" type="number" /></td>
                            <td class="fillable px-2"><input v-model="product.mrp" type="number" /></td>
                            <td class="fillable px-2"><input v-model="product.quantity" type="number"
                                    @change="calculateFields(product)" /></td>
                            <td><input v-model="product.subtotal" type="number" disabled /></td>
                            <td class="fillable px-2"><input
                                    :class="{ 'bg-red': allErrors.has('purchaseProducts.' + index + '.discount') }"
                                    v-model="product.discount" type="number" @change="calculateFields(product)" /></td>
                            <td><input v-model="product.total" type="number" disabled /></td>
                            <td>
                                <button @click="removeProduct(index)" class="btn btn-danger btn-sm m-1"><i
                                        class="bx bx-minus me-md-1"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" v-if="purchaseProducts.length > 0">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <div class="float-end">
                        <table class="table estimate-acount-table text-right calculate_final_amount">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>:</td>
                                    <td>{{ purchase.subtotal }}</td>
                                    <input type="hidden" name="sub_total" v-model="purchase.subtotal" />
                                </tr>
                                <tr>
                                    <th>Medicines Discount</th>
                                    <td>:</td>
                                    <td>{{ purchase.medicine_discount }}</td>
                                    <input type="hidden" name="medicine_discount" v-model="purchase.medicine_discount" />
                                </tr>
                                <tr class="d-none">
                                    <th>Invoice Discount</th>
                                    <td>:</td>
                                    <td>
                                        <input name="invoice_discount_amount" type="number"
                                            v-model="purchase.invoice_discount_amount" />
                                        <select name="invoice_discount_type" v-model="purchase.invoice_discount_type">
                                            <option value="percent">%</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>:</td>
                                    <td>{{ purchase.total }}</td>
                                    <input type="hidden" id="totalAmount" name="total" v-model="purchase.total" />
                                </tr>
                                <tr>
                                    <th>Paid Amount</th>
                                    <td>:</td>
                                    <td class="fillable">
                                        <input type="number" name="paid" v-model="purchase.paid" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Amount</th>
                                    <td>:</td>
                                    <td>
                                    <td>{{ purchase.due }}</td>
                                    <input id="dueAmount" type="hidden" name="due" v-model="purchase.due" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>:</td>
                                    <td>
                                        <select name="payment_method_id" v-model="purchase.payment_method_id"
                                            :class="{ 'bg-red': allErrors.has('purchase.payment_method_id') }">
                                            <option value="">Select one</option>
                                            <option v-for="method in paymentMethods" :value="method.id" :key="method.id">{{
                                                method.name }}</option>
                                        </select>
                                    </td>

                                    <input type="hidden" name="total_quantity" v-model="purchase.total_quantity" />
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <button @click="submitForm" class="form-control bg-dark text-light">Submit</button>
                                    </td>
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
import _ from "lodash";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';
import Errors from "../../errors/errors";

export default {
    data() {
        return {
            medicine_barcode: null,
            purchaseProducts: [],
            suppliers: [],
            paymentMethods: [],
            purchase: {
                subtotal: 0,
                medicine_discount: '',
                total: '',
                invoice_discount_amount: 0,
                paid: 0,
                due: 0,
                total_quantity: 0,
                payment_method_id: '',
                invoice_discount_type: 'percent',
                supplier_id: '',
            },
            allErrors: new Errors(),
        };
    },
    watch: {
        medicine_barcode: _.debounce(function () {
            this.getproductByBarcode();
        }, 500),
        purchaseProducts: {
            handler: function () {
                this.calculateFields();
            },
            deep: true
        }, 'purchase.invoice_discount_amount': function () {
            this.calculateFields();
        },
        'purchase.invoice_discount_type': function () {
            this.calculateFields();
        },
        'purchase.paid': function (newValue) {
            if (newValue > this.purchase.total) {
                this.purchase.paid = this.purchase.total;
                toastr.error("Paid Amount not getter then payable amount")
            }
            this.calculateFields();
        }
    },
    methods: {
        addProduct(product) {
            this.purchaseProducts.push(product);
        },
        getproductByBarcode: _.debounce(function () {

            if (this.medicine_barcode != null)
                axios
                    .get(`medicine-by-barcode/${this.medicine_barcode}`)
                    .then((response) => {
                        if (response && response.data) {
                            const { barcode, name, id } = response.data.result;
                            const existingProduct = this.purchaseProducts.find(product => product.barcode === barcode);

                            if (existingProduct) {
                                existingProduct.quantity += 1;
                                toastr.success("Update Requested product quantity");
                            } else {
                                const product = {
                                    id,
                                    barcode,
                                    name,
                                    expire_date: '',
                                    quantity: 1,
                                    pp: 0,
                                    mrp: 0,
                                    subtotal: 0,
                                    discount: 0,
                                    total: 0
                                };
                                this.addProduct(product);
                                toastr.success("Medicine Added successfully");
                            }
                            this.medicine_barcode = null;
                        } else {
                            toastr.error('Invalid response received');
                        }
                    })
                    .catch((error) => {
                        handleErrorResponse.call(this, error);
                    });
        }, 500),
        removeProduct(index) {
            this.purchaseProducts.splice(index, 1);
        },
        submitForm() {
            const formData = {
                purchaseProducts: this.purchaseProducts,
                purchase: this.purchase,
            };
            console.log(formData);
            axios
                .post('purchase', formData)
                .then((response) => {
                    handleSuccessResponse.call(this, response);

                    this.purchaseProducts = [];
                    this.purchase = {
                        subtotal: 0,
                        medicine_discount: '',
                        total: '',
                        invoice_discount_amount: 0,
                        paid: 0,
                        due: 0,
                        total_quantity: 0,
                        payment_method_id: '',
                        invoice_discount_type: 'percent',
                    };
                })
                .catch((error) => {
                    // Handle the error response
                    handleErrorResponse.call(this, error);
                });

        },
        calculateFields() {
            let subtotal = 0;
            let medicineDiscount = 0;
            let totalQuantity = 0;

            this.purchaseProducts.forEach((product) => {
                product.subtotal = (product.pp * product.quantity).toFixed(2);
                if (product.discount > 100) {
                    product.discount = 100;
                    toastr.warning("Max discount can be 100");
                }
                product.total = (product.subtotal - (product.subtotal * product.discount / 100)).toFixed(2);
                subtotal += parseFloat(product.total);
                medicineDiscount += (product.subtotal - product.total);
                totalQuantity += product.quantity;
            });

            this.purchase.subtotal = subtotal.toFixed(2);
            this.purchase.medicine_discount = medicineDiscount.toFixed(2);
            this.purchase.total = (this.purchase.invoice_discount_type === 'percent')
                ? (subtotal - (subtotal * parseFloat(this.purchase.invoice_discount_amount) / 100)).toFixed(2)
                : (subtotal - parseFloat(this.purchase.invoice_discount_amount || 0)).toFixed(2);
            this.purchase.total = parseFloat(this.purchase.total);

            // Round the total to the nearest whole number
            this.purchase.total = Math.round(this.purchase.total);
            this.purchase.due = (this.purchase.total - this.purchase.paid).toFixed(2);
            this.purchase.total_quantity = totalQuantity;

        },
        getSuppliers() {
            axios
                .get('/supplier', { params: { paginate: true } })
                .then((response) => {
                    this.suppliers = response.data.result;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        getPaymentMethods() {
            axios
                .get('/payment-method', { params: { paginate: true } })
                .then((response) => {
                    this.paymentMethods = response.data.result;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
    },
    created() {
        this.getPaymentMethods();
        this.getSuppliers();
    },
    computed: {
        stringLength() {
            return this.medicine_barcode.length;
        },
    },
};


</script>

<style scoped>
.table-sm td input {
    width: 100%;
    background-color: transparent;
    border: none !important;
    text-align: center;
}

.layout-menu {
    display: none !important;
}

.layout-page {
    padding: 0px 2rem !important;
}

.table-sm> :not(caption)>*>* {
    padding: 0px;
}

.list-group-item {
    padding: .2rem .2rem;
}

.badge {
    padding: 0px;
    line-height: 1.75;
    font-size: .860rem;
    color: black;
}

.calculate_final_amount input[type="number"] {
    width: 100px;
}

.calculate_final_amount select {
    height: 28px;
}

.bg-red {
    background-color: red !important;
    color: #fff;
}

input:focus {
    outline: none;
    /* Remove the outline (border) */
}

.fillable {
    margin: 0px 10px !important;
}

.fillable input[type="number"],
.fillable input[type="date"] {
    border: 1px solid #444444 !important;
    background-color: #233446;
    border-radius: 6px;
    color:#fff;
}</style>
