<template>
    <div @keydown="clearError($event.target.name)">
        <div class="card py-4 vh-100">
            <div class="row  ">
                <div class="col-md-8 px-4 border-right-2 border-dark" id="vertical-example">
                    <div class="row">
                        <div class="col-12 col-md-6 d-flexgap-2">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-text"></i></span>
                                <input type="text" class="form-control" placeholder="Search by Medicine Name/ generic name"
                                    v-model="medicine_name">
                            </div>
                            <div class="items">
                                <div class="card shadow-none bg-transparent border border-primary mb-3"
                                    v-for="(medicine, index) in searchMedicine" :key="index">
                                    <div class="p-2 d-flex align-items-center justify-content-between">
                                        <div class="content">
                                            <b class="card-title">{{ medicine.name }}</b>
                                            <p class="card-text">Generic: <span class="tag-input">{{ medicine.generic
                                            }}</span>,
                                                Barcode: <span class="tag-input">{{
                                                    medicine.barcode }}</span> </p>
                                        </div>
                                        <div class="action">
                                            <button @click="addToBarcode(medicine.barcode)"
                                                class="btn btn-primary btn-xs m-1"><i class="bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                        class="bx bx-barcode"></i></span>
                                <input type="text" class="form-control" placeholder="Barcode" name="medicine_barcode"
                                    v-model="medicine_barcode">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap px-md-3">
                        <table class="table table-sm text-center">
                            <thead>
                                <tr>
                                    <!-- <th>#SN</th> -->
                                    <th class="d-none">Barcode</th>
                                    <th>Name</th>
                                    <th class="d-none">Stock</th>
                                    <th>Expire</th>
                                    <th>M.R.P</th>
                                    <th>QTY</th>
                                    <th class="d-none">Subtotal</th>
                                    <th class="discount">Dis(%)</th>
                                    <th>Total</th>
                                    <th> <i class="bx bx-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody v-if="saleProducts.length > 0">
                                <tr v-for="(product, index) in saleProducts" :key="index">
                                    <!-- <th scope="row">{{ index + 1 }}</th> -->
                                    <td class="barcode d-none">
                                        <input type="hidden" v-model="product.id">
                                        <input v-model="product.barcode" type="text" disabled />
                                    </td>
                                    <td class="name">{{ product.name }}</td>
                                    <td class="stock d-none">{{ product.available }}</td>
                                    <td class="fillable px-2">
                                        <select v-model="product.expire_date" @change="getMRPByExpireDate(product)">
                                            <option v-for="batch in product.stock_by_batch" :key="batch.expire_date"
                                                :value="batch.expire_date">
                                                {{ batch.expire_date }}
                                            </option>
                                        </select>
                                    </td>
                                    <td class="mrp"><input v-model="product.mrp" type="number" disabled /></td>
                                    <td class="qty fillable px-2"><input v-model="product.quantity" type="number"
                                            @change="calculateFields(product)" min="1"
                                            :class="{ 'bg-red': allErrors.has('saleProducts.' + index + '.quantity') }" />
                                    </td>
                                    <td class="d-none"><input v-model="product.subtotal" type="number" disabled />
                                    </td>
                                    <td class="fillable px-2"><input v-model="product.discount" type="number"
                                            @change="calculateFields(product)"
                                            :class="{ 'bg-red': allErrors.has('saleProducts.' + index + '.discount') }" />
                                    </td>
                                    <td><input v-model="product.total" type="number" disabled /></td>
                                    <td>
                                        <button @click="removeProduct(index)" class="btn btn-danger btn-xs m-1"><i
                                                class="bx bx-minus"></i></button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="input-group">
                            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#instantCustomer"
                                for="phone" @click="addNewCustomer"><i class="bx bx-user-plus"></i></button>
                            <v-select :options="customers" :label="'phone'" name="customer_id"
                                :placeholder="'Select Customer'" :reduce="customer => customer.id"
                                v-model="sale.customer_id" style="width: 90%;"></v-select>
                            <!-- <router-link class="btn btn-sm btn-dark" :to="{name:'dashboard'}"> <i class="bx bx-home"></i></router-link> -->
                        </div>
                        <span v-if="this.allErrors.has('sale.customer_id')" class="error text-danger fw-semibold mt-3"
                            v-text="this.allErrors.get('sale.customer_id')"></span>
                        <div class="col-md-12">
                            <div class="float-end">
                                <table class="table estimate-acount-table text-right calculate_final_amount">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>:</td>
                                            <td>{{ sale.subtotal }}</td>
                                            <input type="hidden" name="sub_total" v-model="sale.subtotal" />
                                        </tr>
                                        <tr>
                                            <th>Medicines Discount</th>
                                            <td>:</td>
                                            <td>{{ sale.medicine_discount }}</td>
                                            <input type="hidden" name="medicine_discount"
                                                v-model="sale.medicine_discount" />
                                        </tr>
                                        <tr>
                                            <th>Invoice Discount</th>
                                            <td>:</td>
                                            <td class="d-flex">
                                                <input name="invoice_discount_amount" type="number"
                                                    v-model="sale.invoice_discount_amount" />
                                                <select name="invoice_discount_type" v-model="sale.invoice_discount_type">
                                                    <option value="percent">%</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>:</td>
                                            <td>{{ sale.total }}</td>
                                            <input type="hidden" id="totalAmount" name="total" v-model="sale.total" />
                                        </tr>
                                        <tr>
                                            <th>Paid Amount</th>
                                            <td>:</td>
                                            <td class="fillable px-2">
                                                <input type="number" name="paid" v-model="sale.paid" />
                                            </td>
                                        </tr>
                                        <tr class="table-sm">
                                            <th>Due Amount</th>
                                            <td>:</td>
                                            <td>
                                                <input id="dueAmount" type="number" name="due" v-model="sale.due"
                                                    disabled />
                                            </td>
                                        </tr>
                                        <tr :class="{ 'bg-danger': allErrors.has('sale.payment_method_id') }">
                                            <th>Payment Method</th>
                                            <td>:</td>
                                            <td class="fillable px-2">
                                                <select name="payment_method_id" v-model="sale.payment_method_id">
                                                    <option v-for="method in paymentMethods" :value="method.id"
                                                        :key="method.id">
                                                        {{ method.name }}
                                                    </option>
                                                </select>

                                            </td>
                                            <input type="hidden" name="total_quantity" v-model="sale.total_quantity" />
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <div class="d-flex">
                                                    <button @click="submitForm"
                                                        class="form-control bg-dark text-light">Save</button>
                                                    <button @click="submitFormPrint"
                                                        class="form-control bg-dark text-light">Save And Print</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <template class="d-none">
        <Invoice80 :saleData="saleData" />
    </template>
    <!-- Modal -->
    <div class="modal" v-if="isModalOpen">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">New Customer</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <form @submit.prevent="createCustomer">
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Walking Customer"
                                    v-model="customer.name" />
                                <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('name')">
                                </span>
                            </div>
                            <div class="col mb-0">
                                <label for="phone" class="form-label">Contact No</label>
                                <input type="text" id="phone" class="form-control" placeholder="01xxxxxxxxx"
                                    @keydown="clearError('phone')" v-model="customer.phone" ref="customerphone" />
                                <span v-if="this.allErrors.has('phone')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('phone')">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" @click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';
import numberToWords from 'number-to-words';
import Invoice80 from "./80mm.vue";
export default {
    components: {
        Invoice80,
    },
    data() {
        return {
            allErrors: new Errors(),
            medicine_barcode: '',
            medicine_name: '',
            saleProducts: [],
            paymentMethods: [],
            customers: [],
            sale: {
                subtotal: parseFloat(Math.round(0)).toFixed(2),
                medicine_discount: parseFloat(Math.round(0)).toFixed(2),
                total: parseFloat(Math.round(0)).toFixed(2),
                invoice_discount_amount: parseFloat(Math.round(0)).toFixed(2),
                paid: parseFloat(Math.round(0)).toFixed(2),
                due: parseFloat(Math.round(0)).toFixed(2),
                total_quantity: 0,
                payment_method_id: 0,
                invoice_discount_type: 'percent',
                customer_id: null
            },
            categories: [],
            menufacturers: [],
            searchMedicine: [],
            saleData: {
                result: {
                    sale_details: [],
                    sale_payment: [],
                    sale_exchange: [],
                    customer: {},
                    sale_return: [],
                    numberTotext: ''
                },
            },
            customer: {
                name: 'Unknow Customer',
                phone: '',
            },
            isModalOpen: false,
        };
    },
    watch: {
        medicine_barcode: _.debounce(function () {
            if (this.medicine_barcode !=null) {
                this.getproductByBarcode();
            }
        }, 500),
        medicine_name: _.debounce(function () {
            this.getproductByDetails();
        }, 500),
        saleProducts: {
            handler: function () {
                this.calculateFields();
            },
            deep: true
        }, 'sale.invoice_discount_amount': function () {
            this.calculateFields();
        },
        'sale.invoice_discount_type': function () {
            this.calculateFields();
        },
        'sale.paid': function (newValue) {
            if (newValue > this.sale.total) {
                this.sale.paid = this.sale.total;
                toastr.error("Paid Amount not getter then payable amount")
            }
            this.calculateFields();
        }
    },
    methods: {
        addProduct(product) {
            this.saleProducts.push(product);
        },
        async getproductByBarcode() {
            try {
                const response = await axios.get(`medicine-stock-by-barcode/${this.medicine_barcode}`);

                if (response?.data) {
                    const { barcode, name, id, stock_by_batch } = response.data.result;
                    const existingProduct = this.saleProducts.find((product) => product.barcode === barcode);

                    if (existingProduct) {
                        existingProduct.quantity += 1;
                        toastr.success("Update Requested product quantity");
                    } else {
                        const product = {
                            id,
                            barcode,
                            name,
                            expire_date: stock_by_batch.length > 0 ? stock_by_batch[0].expire_date : '', // Initialize expire_date as an empty string
                            quantity: 0,
                            mrp: 0,
                            available: 0,
                            subtotal: 0,
                            discount: 0,
                            total: 0,
                            stock_by_batch: stock_by_batch, // Assign the stock_by_batch data
                        };
                        this.getMRPByExpireDate(product);
        
                    }
                    this.medicine_barcode = null;
                } else {
                    toastr.error('Invalid response received');
                }
            } catch (error) {
                handleErrorResponse.call(this, error);
            }
        },
        getproductByDetails: _.debounce(function () {
            axios
                .get(`medicine-by-content/${this.medicine_name}`)
                .then((response) => {
                    this.searchMedicine = response.data.result;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        }, 500),
        removeProduct(index) {
            this.saleProducts.splice(index, 1);
        },
        calculateFields() {
            let subtotal = 0;
            let medicineDiscount = 0;
            let totalQuantity = 0;

            this.saleProducts.forEach((product) => {
                product.subtotal = (product.mrp * product.quantity).toFixed(2);
                if (product.discount > 100) {
                    product.discount = 100;
                    toastr.warning("Max discount can be 100");
                }
                product.total = (product.subtotal - (product.subtotal * product.discount / 100)).toFixed(2);
                subtotal += parseFloat(product.total);
                medicineDiscount += (product.subtotal - product.total);
                totalQuantity += parseInt(product.quantity);
                if (product.available < product.quantity) {
                    product.quantity = product.available
                    toastr.error('Stock is not available');
                }
            });
            
            this.sale.subtotal = subtotal.toFixed(2);
            this.sale.medicine_discount = medicineDiscount.toFixed(2);
            this.sale.total = (this.sale.invoice_discount_type === 'percent')
                ? (subtotal - (subtotal * parseFloat(this.sale.invoice_discount_amount) / 100)).toFixed(2)
                : (subtotal - parseFloat(this.sale.invoice_discount_amount || 0)).toFixed(2);
            this.sale.total = parseFloat(this.sale.total).toFixed(2);

            // Round the total to the nearest whole number
            this.sale.total = parseFloat(Math.round(this.sale.total)).toFixed(2);
            this.sale.due = (this.sale.total - this.sale.paid).toFixed(2);
            this.sale.total_quantity = parseInt(totalQuantity);
            console.log(this.sale.total_quantity);
        },
        getPaymentMethods() {
            axios
                .get('/payment-method', { params: { paginate: true } })
                .then((response) => {
                    this.paymentMethods = response.data.result;
                    const cash = this.paymentMethods.find(account => account.name === 'Cash');
                    if (cash) {
                        this.sale.payment_method_id = cash.id;
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        getCustomers(id) {
            axios
                .get('/customer', { params: { paginate: true } })
                .then((response) => {
                    this.customers = response.data.result;
                    // if(id){
                    //     this.sale.customer_id = id;
                    // }else{
                    //     const walkingCustomer = this.customers.find(customer => customer.name === 'Walking Customer');
                    //     if (walkingCustomer) {
                    //         this.sale.customer_id = walkingCustomer.id;
                    //     };
                    // }
                    const walkingCustomer = this.customers.find(customer => customer.name === 'Walking Customer');
                    if (walkingCustomer) {
                        this.sale.customer_id = walkingCustomer.id;
                    };
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        getCategory() {
            this.loader(true);
            axios.get('/category', {
                params: {
                    paginate: false
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.categories = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                })
        },
        getMenufacture() {
            axios
                .get('/manufacturer', { params: { paginate: false } })
                .then((response) => {
                    this.menufacturers = response.data.result;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        getMRPByExpireDate(product) {
            axios
                .get('get-stock-by-expiredate', { params: { medicine_id: product.id, expire_date: product.expire_date } })
                .then((response) => {
                    if (response && response.data && response.data.result) {
                        const existingProduct = this.saleProducts.find((products) => products.barcode === product.barcode);
                        product.available = response.data.result.total_quantity;
                        
                        
                        if(existingProduct){
                            if (product.available < 1) {
                            product.quantity = 0;
                            toastr.error('Stock is not available');
                        } else {
                            product.mrp = response.data.result.max_mrp;
                            
                            product.quantity = 1;
                            toastr.success('Update Quantity')
                        }
                        }else{
                            if (product.available < 1) {
                            product.quantity = 0;
                            toastr.error('Stock is not available');
                        } else {
                            product.mrp = response.data.result.max_mrp;
                            product.quantity = 1;
                            toastr.success('Medicine Added Successfully')
                            this.addProduct(product);
                        }
                            
                        }
                    } else {
                        toastr.error('Invalid response received from  API');
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },

        async submitFormPrint() {
            try {
                const productsData = this.saleProducts.map((product) => {
                    return {
                        medicine_id: product.id,
                        mrp: product.mrp,
                        expire_date: product.expire_date,
                        quantity: product.quantity,
                        discount: product.discount,
                        subtotal: product.subtotal,
                        total: product.total
                    };
                });

                const formData = {
                    saleProducts: productsData,
                    sale: this.sale,
                };

                // Make the POST request and wait for the response
                const response = await axios.post('sale', formData);

                // Update the component state with the response data
                this.saleData = response.data;
                const number = parseInt(this.saleData.result.total);
                this.saleData.result.numberTotext = numberToWords.toWords(number);

                handleSuccessResponse.call(this, response);
                const cash = this.paymentMethods.find(account => account.name === 'Cash');
                const walkingCustomer = this.customers.find(customer => customer.name === 'Walking Customer');
                // Reset saleProducts and sale data
                this.saleProducts = [];
                this.sale = {
                    subtotal: 0,
                    medicine_discount: '',
                    total: '',
                    invoice_discount_amount: 0,
                    paid: 0,
                    due: 0,
                    total_quantity: 0,
                    payment_method_id: cash.id,
                    invoice_discount_type: 'percent',
                    customer_id: walkingCustomer.id
                };
                // Print after the data is fully updated
                await this.$nextTick(); // Ensure DOM updates before printing
                this.print80mm();
            } catch (error) {
                // Handle the error response
                handleErrorResponse.call(this, error);
            }
        },
        async submitForm() {
            try {
                const productsData = this.saleProducts.map((product) => {
                    return {
                        medicine_id: product.id,
                        mrp: product.mrp,
                        expire_date: product.expire_date,
                        quantity: product.quantity,
                        discount: product.discount,
                        subtotal: product.subtotal,
                        total: product.total
                    };
                });

                const formData = {
                    saleProducts: productsData,
                    sale: this.sale,
                };
  
                const response = await axios.post('sale', formData);
                this.saleData = response.data;
                const number = parseInt(this.saleData.result.total);
                this.saleData.result.numberTotext = numberToWords.toWords(number);
                handleSuccessResponse.call(this, response);
                const walkingCustomer = this.customers.find(customer => customer.name === 'Walking Customer');
                const cash = this.paymentMethods.find(account => account.name === 'Cash');
                this.saleProducts = [];
                this.sale = {
                    subtotal: parseFloat(Math.round(0)).toFixed(2),
                    medicine_discount: parseFloat(Math.round(0)).toFixed(2),
                    total: parseFloat(Math.round(0)).toFixed(2),
                    invoice_discount_amount: parseFloat(Math.round(0)).toFixed(2),
                    paid: parseFloat(Math.round(0)).toFixed(2),
                    due: parseFloat(Math.round(0)).toFixed(2),
                    total_quantity: 0,
                    payment_method_id: cash.id,
                    invoice_discount_type: 'percent',
                    customer_id: walkingCustomer.id
                };
            } catch (error) {
                handleErrorResponse.call(this, error);
            }
        },
        addToBarcode($barcode) {
            this.medicine_barcode = $barcode;
            this.medicine_name = '';
        },
        print80mm() {
            const printContent = document.getElementById('invoiceArea').innerHTML;
            // Create a new window and write the content to it
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`<html>
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
        },
        createCustomer() {
            this.loader(true);
            axios.post('customer', {
                ...this.customer
            })
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.getCustomers(response.data.result.id);
                    this.closeModal();

                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        clearError(fieldName) {
            this.allErrors.errors[fieldName] = null;
        },
        addNewCustomer() {
            this.isModalOpen = true;
            this.$nextTick(() => {
                this.$refs.customerphone.focus();
            });
        },
        closeModal() {
            this.isModalOpen = false;
            this.customer = {
                name: 'Unknow Customer',
                phone: '',
            };
        }
    },
    mounted() {
        this.getPaymentMethods();
        this.getCustomers();
    },
    created() {
    }
}
</script>

<style scoped>
.table-sm td input {
    max-width: 100px;
    background-color: transparent;
    border: none !important;
    text-align: center;
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

.dis,
.qty,
.mrp {
    width: 60px;
}

.name {
    width: 200px;
}

#vertical-example {
    overflow-y: auto;
    max-height: 500px;
}

.addCustomer i {
    font-size: 30px;
}

.tag-input {
    background-color: #ccc;
    padding: 2px;
    border-radius: 8%;
    color: #121212;
}

.border-right-2 {
    border-right: 2px solid;
}

.items {
    padding-top: 2px;
    position: absolute;
    max-height: 80vh !important;
    overflow-y: scroll;
    background: rgba(232, 232, 232, 0.8);
    backdrop-filter: blur(1px);
}

.bg-red {
    background-color: red !important;
    color: #fff;
}

input:focus,
select:focus {
    outline: none;
    /* Remove the outline (border) */
}

.fillable {
    margin: 0px 10px !important;
}

.fillable input[type="number"],
.fillable select {
    border: 1px solid #444444 !important;
    background-color: #233446;
    border-radius: 6px;
    color: #ffffff;
}

.layout-navbar-fixed .layout-navbar {
    display: none !important;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
