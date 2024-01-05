<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><router-link :to="{ name: 'sale.index' }">sale List</router-link>
                /</span>Sale Details
        </h4>
        <div class="card container-p-y" id="invoice">
            <div class="d-flex mt-5 px-2 justify-content-between">
                <div class="col-md-6">
                    <h6 class="card-title mb-2">Customer details</h6>
                    <p class="mb-1">Name: {{ sale.result.customer.name }}</p>
                    <p class="mb-1" v-if="sale.result.customer.name">
                        Email: {{ sale.result.customer.email }}
                    </p>
                    <p class="mb-0" v-if="sale.result.customer.phone">
                        Mobile: {{ sale.result.customer.phone }}
                    </p>
                    <p class="mb-0" v-if="sale.result.customer.address">
                        Address: {{ sale.result.customer.address }}
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
            <div class="table-responsive text-nowrap px-md-3"  v-if="sale?.result?.sale_details.length >0">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>#SN</th>
                            <th class="hide">Barcode</th>
                            <th>Name</th>
                            <th class="hide">Expire</th>
                            <th class="hide">M.R.P</th>
                            <th>Quantity</th>
                            <th class="hide">Subtotal</th>
                            <th class="hide">Dis(%)</th>
                            <th>Total</th>
                            <th class="for-80mm">Return</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in sale.result.sale_details" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td class="hide">
                                {{ product.medicine.barcode }}
                            </td>
                            <td>{{ product.medicine.name }}</td>
                            <td class="hide">{{ product.expire_date }}</td>
                            <td class="hide">{{ product.mrp }} Tk</td>
                            <td>{{ product.quantity }}</td>
                            <td class="hide">{{ product.subtotal }}</td>
                            <td class="hide">{{ product.discount }}%</td>
                            <td>{{ product.total }} Tk</td>
                            <td class="for-80mm"><button v-if="product.current_quantity > 0" type="button"
                                    class="btn btn-sm btn-primary hide-arrow"
                                    @click="openSaleReturnModal(product.id, product.current_quantity, product.quantity, product.total)">
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
            <div class="table-responsive text-nowrap px-md-3" v-if="sale && sale.result && sale.result.sale_exchange.length > 0">
                <p class="fw-bold mt-2">Exchange</p>
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>#SN</th>
                            <th class="hide">Barcode</th>
                            <th>Name</th>
                            <th class="hide">Expire</th>
                            <th class="hide">M.R.P</th>
                            <th>Quantity</th>
                            <th class="hide">Subtotal</th>
                            <th class="hide">Dis(%)</th>
                            <th>Total</th>
                            <th class="for-80mm">Return</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in sale.result.sale_exchange" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td class="hide">
                                {{ product.medicine.barcode }}
                            </td>
                            <td>{{ product.medicine.name }}</td>
                            <td class="hide">{{ product.expire_date }}</td>
                            <td class="hide">{{ product.mrp }} Tk</td>
                            <td>{{ product.quantity }}</td>
                            <td class="hide">{{ product.subtotal }}</td>
                            <td class="hide">{{ product.discount }}%</td>
                            <td>{{ product.total }} Tk</td>
                            <td class="for-80mm"><button v-if="product.current_quantity > 0" type="button"
                                    class="btn btn-sm btn-primary hide-arrow"
                                    @click="openSaleReturnModal(product.id, product.current_quantity, product.quantity, product.total)">
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
                <div class="col-md-7 for-a4">
                    <div class="table-responsive text-nowrap px-md-3">
                        <template v-if="sale && sale.result && sale.result.sale_return.length > 0">
                            <h6 class="card-title mb-2 mt-2"> Medicine Return</h6>
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

                                    <tr v-for="(product, index) in sale.result.sale_return" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>
                                            {{ product.medicine.barcode }}
                                        </td>
                                        <td>{{ product.medicine.name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.price }}</td>
                                        <td><span v-if="product.returnAmount > 0"> {{ product.returnAmount }} <br><strong>{{
                                            product.payment_method.name }}</strong></span> <span v-else>{{product.returnAmount }}</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                    </div>
                    <template v-if="sale && sale.result && sale.result.sale_payment.length > 0">
                        <div class="table-responsive text-nowrap px-md-3">
                            <h6 class="card-title mb-2 mt-2">Payment History</h6>
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
                                    <tr v-for="(product, index) in sale.result.sale_payment" :key="index">
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
                                    <td>{{ sale.result.subtotal }}</td>
                                    <input type="hidden" name="sub_total" v-model="sale.subtotal" />
                                </tr>
                                <tr>
                                    <th>Medicines Dis.</th>
                                    <td>:</td>
                                    <td>{{ sale.result.medicine_discount }} Tk</td>
                                    <input type="hidden" name="medicine_discount" v-model="sale.medicine_discount" />
                                </tr>
                                <tr>
                                    <th>Invoice Discount</th>
                                    <td>:</td>
                                    <td>
                                        {{ sale.result.invoice_discount_amount }}
                                        <span v-if="sale.result.invoice_discount_type === 1">
                                            %</span>
                                        <span v-else>TK</span>
                                    </td>
                                </tr>
                                <tr v-if="sale.result.returnable_price > 0">
                                    <th>Return Price</th>
                                    <td>:</td>
                                    <td>{{ sale.result.returnable_price }} Tk</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>:</td>
                                    <td>{{ sale.result.total - sale.result.returnable_price }}</td>
                                </tr>
                                <tr>
                                    <th>Paid Amount</th>
                                    <td>:</td>
                                    <td>{{ sale.result.total_paid }} Tk</td>
                                </tr>
                                <tr v-if="sale.result.return_price > 0">
                                    <th>Return Amount</th>
                                    <td>:</td>
                                    <td>
                                        {{ sale.result.return_price }} Tk
                                    </td>
                                </tr>
                                <tr v-if="totalDue !== 0">
                                    <th>
                                        Due Amount
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow"
                                            @click="openDuePaymentModal">
                                            <i class="bx bx-message-alt-add"></i>
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

    <PaymentCollectionModal :saleId="sale.result.id" :dueAmount="totalDue" @payment-success="getSale" />
    <template v-if="selectedProductId != null">
        <ProductReturn :detailId="selectedProductId" :Instock="selectedAvailableStock" :quantity="selectedquantity"
        :total="selectedtotal" :due="totalDue" :method="paymentMethods" :customer="sale.result.customer.id" :paymentMethods="paymentMethods" @return-success="getSale" />
    </template>

    <div class="d-none">
        <Invoice80 :saleData="sale"  />
    </div>
</template>

<script>
import _ from "lodash";
import PaymentCollectionModal from "./duePaymentModal.vue";
import ProductReturn from "./SaleReturn.vue";
import Invoice80 from "./80mm.vue";
import { handleErrorResponse } from "../../errors/errorHandler.js";
import numberToWords from 'number-to-words';
import { userStore } from "../../stores/user";
export default {
    components: {
        PaymentCollectionModal,
        ProductReturn,
        Invoice80,
    },
    data() {
        return {
            sale: {
                result: {
                    sale_details: [],
                    sale_payment: [],
                    sale_exchange: [],
                    customer: {},
                    sale_return: [],
                    numberTotext:'',
                },
            },
            dueAmount: 0,
            selectedProductId: null,
            selectedAvailableStock: 0,
            selectedquantity: 0,
            selectedtotal: 0,
            paymentMethods: [],
            user:{}
        };
    },
    computed: {
        totalDue() {
            const total = this.sale.result.total;
            const totalPaid = this.sale.result.total_paid;
            const returnable_price = this.sale.result.returnable_price;
            const return_price = this.sale.result.return_price;
            const dueAmount = total + return_price - totalPaid - returnable_price;
            return dueAmount;
        },

    },
    methods: {
        getSale() {
            axios
                .get(`sale/${this.$route.params.id}`)
                .then((response) => {
                    this.sale = response.data;
                    const number = parseInt(this.sale.result.total -this.sale.result.returnable_price);
                    this.sale.result.numberTotext = numberToWords.toWords(number);
                    // console.log(this.sale.result.numberTotext);
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        openDuePaymentModal() {
            // Show the Payment Collection modal when the button is clicked
            $("#paymentCollectionModal").modal("show");
        },
        openSaleReturnModal(productId, availableStock, quantity, total) {
            this.selectedProductId = productId;
            this.selectedAvailableStock = availableStock;
            this.selectedquantity = quantity;
            this.selectedtotal = total;
            $('#salereturnModal').modal('show');
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
        print80mm() {

            const printContent = document.getElementById('invoiceArea').innerHTML;

            // Create a new window and write the content to it
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

            // Trigger the print dialog
            printWindow.print();
            const afterPrintHandler = () => {
                printWindow.close();
                window.removeEventListener('afterprint', afterPrintHandler);
            };


            window.addEventListener('afterprint', afterPrintHandler);
            setTimeout(() => {
                printWindow.close();
            }, 1000);
        }
    },
    created() {
        this.getSale();
        this.fetchPaymentMethods();
        const userInfo = userStore();
        this.user = userInfo.user;
    }
}
</script>

<style>
.list-group-item {
    padding: 0.2rem 0.2rem;
}

.badge {
    padding: 0px;
    line-height: 1.75;
    font-size: 0.86rem;
    color: black;

}

.calculate_final_amount input[type="number"] {
    width: 100px;
}

.calculate_final_amount select {
    height: 28px;
}
</style>