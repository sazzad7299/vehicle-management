<template>
    <PaymentCollectionModal :purchaseId="purchase.result.id" :dueAmount="totalDue" :paymentMethods="paymentMethods"
        @payment-success="getPurchase" />
    <ProductReturn :detailId="selectedProductId" :Instock="selectedAvailableStock" :quantity="selectedquantity"
        :total="selectedtotal" :due="totalDue" :method="paymentMethods" :paymentMethods="paymentMethods"
        @payment-success="getPurchase" />

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><router-link
                    :to="{ name: 'purchase.index' }">Purchase List</router-link> /</span>Purchase Details = > {{
                        purchase.result.created_at }}</h4>
        <div class="card py-5 px-2" id="invoice">
            <div class="row mt-3">
                <div class="col-md-6 px-5">
                    <h6 class="card-title mb-2">Supplier details</h6>
                    <p class="mb-1">Name: {{ purchase.result.supplier.name }}</p>
                    <p class="mb-1" v-if="purchase.result.supplier.name">
                        Email: {{ purchase.result.supplier.email }}
                    </p>
                    <p class="mb-0" v-if="purchase.result.supplier.phone">
                        Mobile: {{ purchase.result.supplier.phone }}
                    </p>
                    <p class="mb-0" v-if="purchase.result.supplier.address">
                        Address: {{ purchase.result.supplier.address }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h4 class="card-title mb-2">{{ user.pharmacy.company_name }}</h4>
                    <p class="mb-1" v-if="user.pharmacy.mobile_no">
                        Contact No: {{ user.pharmacy.mobile_no }}
                    </p>
                    <p class="mb-0" v-if="user.pharmacy.street_address">
                        Address: {{ user.pharmacy.street_address }}
                    </p>
                </div>
            </div>
            <div class="table-responsive text-nowrap px-md-3">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>#SN</th>
                            <th class="for-80mm">Barcode</th>
                            <th>Name</th>
                            <th>Expire</th>
                            <!-- <th>Batch</th> -->
                            <th>P.P</th>
                            <th>M.R.P</th>
                            <th>QTY</th>
                            <th class="for-80mm">In-stock</th>
                            <th>Subtotal</th>
                            <th>Dis(%)</th>
                            <th>Total</th>
                            <th class="for-80mm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in purchase.result.purchase_details" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td class="for-80mm">
                                {{ product.medicine.barcode }}
                            </td>
                            <td>{{ product.medicine.name }}</td>
                            <td>{{ product.expire_date }}</td>
                            <!-- <td>{{ product.batch }}</td> -->
                            <td>{{ product.pp }} TK</td>
                            <td>{{ product.mrp }} Tk</td>
                            <td>{{ product.quantity }}</td>
                            <td class="for-80mm">{{ product.available_stock }}</td>
                            <td>{{ product.subtotal }}</td>
                            <td>{{ product.discount }}%</td>
                            <td>{{ product.total }} Tk</td>
                            <td class="for-80mm"><button v-if="product.available_stock > 0" type="button"
                                    class="btn btn-sm btn-primary hide-arrow"
                                    @click="openPurchaseReturnModal(product.id, product.available_stock, product.quantity, product.total)">
                                    <i class='bx bx-revision'></i>
                                </button>
                                <button v-else type="button" class="btn btn-sm btn-danger hide-arrow">
                                    <i class='bx bx-block'></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-7 p-4">
                    <div class="table-responsive text-nowrap mb-4">
                        <template v-if="purchase && purchase.result && purchase.result.purchase_returns.length > 0">
                            <h5> Medicine Return</h5>
                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#SN</th>
                                        <th>Barcode</th>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Return</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(product, index) in purchase.result.purchase_returns" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>
                                            {{ product.medicine.barcode }}
                                        </td>
                                        <td>{{ product.medicine.name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.price }}</td>
                                        <td><span v-if="product.returnAmount > 0"> {{ product.returnAmount }} <br><strong>{{
                                            product.payment_method.name }}</strong></span> <span v-else>{{
        product.returnAmount }}</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                    </div>
                    <template v-if="purchase && purchase.result && purchase.result.purchase_payment.length > 0">
                        <div class="table-responsive text-nowrap">
                            <h5> Payment List</h5>
                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#SN</th>
                                        <th>Pay By</th>
                                        <th>Paid</th>
                                        <th>Discount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in purchase.result.purchase_payment" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>
                                            {{ product.payment_method.name }}
                                        </td>
                                        <td>{{ product.paid }}</td>
                                        <td>{{ product.discount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </div>
                <div class="col-md-5">
                    <div class="float-end">
                        <table class="table estimate-acount-table text-right calculate_final_amount">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>:</td>
                                    <td>{{ purchase.result.subtotal }}</td>
                                    <input type="hidden" name="sub_total" v-model="purchase.subtotal" />
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td>:</td>
                                    <td>{{ purchase.result.medicine_discount }}</td>
                                    <input type="hidden" name="medicine_discount" v-model="purchase.medicine_discount" />
                                </tr>
                                <!-- <tr>
                                    <th>Invoice Discount</th>
                                    <td>:</td>
                                    <td>
                                        {{ purchase.result.invoice_discount_amount }} <span
                                            v-if="purchase.result.invoice_discount_type === 1"> %</span> <span
                                            v-else>TK</span>
                                    </td>
                                </tr> -->
                                <tr v-if="purchase.result.returnable_price > 0">
                                    <th>Return Total</th>
                                    <td>:</td>
                                    <td>{{ purchase.result.returnable_price }} Tk</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>:</td>
                                    <td>{{ purchase.result.total - purchase.result.returnable_price }} Tk</td>
                                </tr>
                                <tr>
                                    <th>Paid Amount</th>
                                    <td>:</td>
                                    <td>
                                        {{ purchase.result.total_paid }} Tk
                                    </td>
                                </tr>
                                <tr v-if="purchase.result.return_price > 0">
                                    <th>Return Amount</th>
                                    <td>:</td>
                                    <td>
                                        {{ purchase.result.return_price }} Tk
                                    </td>
                                </tr>
                                <tr v-if="totalDue !== 0">
                                    <th>Due Amount
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow"
                                            @click="openDuePaymentModal">
                                            <i class='bx bx-message-alt-add'></i>
                                        </button>
                                    </th>
                                    <td>:</td>
                                    <td>
                                        {{ totalDue }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="card container-p-y">
            <div class="col-auto mx-auto">
                <button class="btn btn-primary m-2" @click="printA4">Print A4</button>
                <button class="btn btn-success" @click="print80mm">Print 80mm</button>
            </div>
        </div>
    </div>
    <div class="d-none">
        <Invoice80 :purchaseData="purchase" :user="user" />
    </div>
</template>

<script>
import _ from "lodash";
import numberToWords from 'number-to-words';
import PaymentCollectionModal from './duePaymentModal.vue';
import ProductReturn from './PurchaseReturn.vue';
import Invoice80 from "./80mm.vue";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { userStore } from "../../stores/user";


export default {
    data() {
        return {
            purchase: {
                result: {
                    purchase_details: [],
                    purchase_payment: [],
                    purchase_returns: [],
                    supplier: {},
                    numberTotext: '',
                }
            },
            dueAmount: 0,
            selectedProductId: null,
            selectedAvailableStock: 0,
            selectedquantity: 0,
            selectedtotal: 0,
            paymentMethods: [],
            user: null,
        };
    },
    computed: {
        totalDue() {
            const total = this.purchase.result.total;
            const totalPaid = this.purchase.result.total_paid;
            const returnable_price = this.purchase.result.returnable_price;
            const return_price = this.purchase.result.return_price;
            const dueAmount = total + return_price - totalPaid - returnable_price;
            return dueAmount;
        }
    },
    components: {
        PaymentCollectionModal,
        ProductReturn,
        Invoice80
    },
    methods: {
        getPurchase() {
            this.loader(true);
            axios
                .get(`purchase/${this.$route.params.id}`)
                .then((response) => {
                    this.purchase = response.data;
                    const number = parseInt(this.purchase.result.total - this.purchase.result.returnable_price);
                    this.purchase.result.numberTotext = numberToWords.toWords(number);
                    console.log(this.purchase.result.numberTotext);
                    this.loader(false);
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        openDuePaymentModal() {
            // Show the Payment Collection modal when the button is clicked
            $('#paymentCollectionModal').modal('show');
        },
        openPurchaseReturnModal(productId, availableStock, quantity, total) {
            this.selectedProductId = productId;
            this.selectedAvailableStock = availableStock;
            this.selectedquantity = quantity;
            this.selectedtotal = total;

            $('#purchasereturnModal').modal('show');
        },
        fetchPaymentMethods() {
            axios.get('/payment-method', { params: { paginate: true } })
                .then((response) => {
                    this.paymentMethods = response.data.result;
                    this.$emit('payment-method');
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        print80mm() {
            const printContent = document.getElementById('invoiceArea').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                        <html>
                        <head>
                        <title>Print</title>
                        <!-- Add any necessary styles here -->
                        </head>
                        <body>
                        ${printContent}
                        </body>
                        </html>
                        `);
            printWindow.document.close();
            printWindow.print();
            const afterPrintHandler = () => {
                printWindow.close();
                window.removeEventListener('afterprint', afterPrintHandler);
            };
            window.addEventListener('afterprint', afterPrintHandler);
            setTimeout(() => {
                printWindow.close();
            }, 1000);
        },
        printA4() {
            const printContent = document.getElementById('invoice').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`<html><head><title>Invoice</title>
                                    <!-- Include any necessary styles here -->
                                    <link rel="stylesheet" href="/backend/assets/vendor/css/core.css" class="template-customizer-core-css"/>
                                    <style>
                                    .for-80mm {
                                        display: none;
                                    }
                                    </style></head><body>${printContent}</body></html>`);
            printWindow.document.close();
            printWindow.print();
            const afterPrintHandler = () => {
                printWindow.close();
                window.removeEventListener('afterprint', afterPrintHandler);
            };
            window.addEventListener('afterprint', afterPrintHandler);
            setTimeout(() => {
                printWindow.close();
            }, 1000);
        },
    },
    created() {
        this.getPurchase();
        this.fetchPaymentMethods();
        const userInfo = userStore();
        this.user = userInfo.user;
    },
};
</script>

<style>
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
</style>
