<template lang="">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light"
        ><router-link :to="{ name: 'sale.index' }">Sale</router-link> /</span
      >Exchange
    </h4>
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            <div
              class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"
            >
              <div class="input-group input-group-merge">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Invoice"
                  name="medicine_barcode"
                  v-model="invoice"
                />
                <span
                  id="basic-icon-default-fullname2"
                  class="input-group-text btn btn-dark btn-sm"
                  @click="getInvoice"
                  ><i class="bx bx-search"></i
                ></span>
              </div>
            </div>

          </div>
          <div class="col-md-6"></div>
            <div class="col-12">
            <template v-if="sale && sale.result && sale.result.sale_details.length > 0">
              <div class="table-responsive text-nowrap px-md-3">
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
                      <th>Current QTY</th>
                      <th>Exchange</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(product, index) in sale.result.sale_details"
                      :key="index"
                    >
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
                      <td>{{ product.current_quantity }}</td>
                      <td>{{ product.total }} Tk</td>
                      <td>
                        <button
                          v-if="product.current_quantity > 0"
                          type="button"
                          class="btn btn-sm btn-primary hide-arrow"
                          @click="exchangeProducts(index,product)"
                        >
                          <i class="bx bx-plus"></i>
                        </button>
                        <button
                          v-else
                          type="button"
                          class="btn btn-sm btn-danger hide-arrow"
                        >
                          <i class="bx bx-block"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-7 for-a4">
                  <div class="table-responsive text-nowrap px-md-3">
                    <template
                      v-if="
                        sale &&
                        sale.result &&
                        sale.result.sale_return.length > 0
                      "
                    >
                      <h6 class="card-title mb-2 mt-2">Medicine Return</h6>
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
                          <tr
                            v-for="(product, index) in sale.result.sale_return"
                            :key="index"
                          >
                            <th scope="row">{{ index + 1 }}</th>
                            <td>
                              {{ product.medicine.barcode }}
                            </td>
                            <td>{{ product.medicine.name }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                              <span v-if="product.returnAmount > 0">
                                {{ product.returnAmount }} <br /><strong>{{
                                  product.payment_method.name
                                }}</strong></span
                              >
                              <span v-else>{{ product.returnAmount }}</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </template>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="float-end">
                    <table
                      class="table estimate-acount-table text-right calculate_final_amount"
                    >
                      <tbody>
                        <tr>
                          <th>Subtotal</th>
                          <td>:</td>
                          <td>{{ sale.result.subtotal }}</td>
                          <input
                            type="hidden"
                            name="sub_total"
                            v-model="sale.subtotal"
                          />
                        </tr>
                        <tr>
                          <th>Medicines Discount Total</th>
                          <td>:</td>
                          <td>{{ sale.result.medicine_discount }}</td>
                          <input
                            type="hidden"
                            name="medicine_discount"
                            v-model="sale.medicine_discount"
                          />
                        </tr>
                        <tr>
                          <th>Invoice Discount</th>
                          <td>:</td>
                          <td>
                            {{ sale.result.invoice_discount_amount }}
                            <span
                              v-if="sale.result.invoice_discount_type === 1"
                            >
                              %</span
                            >
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
                          <td>
                            {{
                              sale.result.total - sale.result.returnable_price
                            }}
                          </td>
                        </tr>
                        <tr>
                          <th>Paid Amount</th>
                          <td>:</td>
                          <td>{{ sale.result.total_paid }} Tk</td>
                        </tr>
                        <tr v-if="sale.result.return_price > 0">
                          <th>Return Amount</th>
                          <td>:</td>
                          <td>{{ sale.result.return_price }} Tk</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </template>

            <template v-if="exchange && exchange.products && exchange.products.length > 0">
                <p class="fw-bold">Exchange Product</p>
              <div class="table-responsive text-nowrap px-md-3">
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
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(product, index) in exchange.products"
                      :key="index"
                    >
                      <th scope="row">{{ index + 1 }}</th>
                      <td class="hide">
                        {{ product.barcode }}
                      </td>
                      <td>{{ product.name }}</td>
                      <td class="hide">{{ product.expire_date }}</td>
                      <td class="hide">{{ product.mrp }} Tk</td>
                      <td>{{ product.quantity }}</td>
                      <td class="hide">{{ product.subtotal }}</td>
                      <td class="hide">{{ product.discount }}%</td>
                      <td>{{ product.total }} Tk</td>
                      <td>
                        <button
                          v-if="product.current_quantity > 0"
                          type="button"
                          class="btn btn-sm btn-danger hide-arrow"
                          @click="removeProducts(index)"
                        >
                          <i class="bx bx-minus"></i>
                        </button>
                        <button
                          v-else
                          type="button"
                          class="btn btn-sm btn-danger hide-arrow"
                        >
                          <i class="bx bx-block"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row justify-content-end">
                <div class="col-md-5">
                  <div class="">
                    <table
                      class="table estimate-acount-table text-right calculate_final_amount"
                    >
                      <tbody>
                        <tr>
                          <th>Total</th>
                          <td>:</td>
                          <td>{{ exchange.total }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <p class="fw-bold">New Product</p>
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
                            <input type="number" class="form-control" placeholder="Barcode" name="medicine_barcode"
                                v-model="medicine_barcode">
                        </div>
                    </div>
               </div>
             <div class="row">
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
                                    <td class="fillable px-2"><input v-model="product.quantity" type="number"
                                            @change="calculateFields(product)" min="1" /></td>
                                    <td class="d-none"><input v-model="product.subtotal" type="number" disabled />
                                    </td>
                                    <td class="fillable px-2" ><input v-model="product.discount" type="number"
                                            @change="calculateFields(product)" min="0" max="100" /></td>
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
             <div class="row justify-content-end">
                <div class="col-md-5">
                    <table class="table estimate-acount-table text-right calculate_final_amount">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>:</td>
                            <td>{{ newSale.subtotal }}</td>
                            <input type="hidden" name="sub_total" v-model="sale.subtotal" />
                        </tr>
                        <tr>
                            <th>Medicines Discount</th>
                            <td>:</td>
                            <td>{{ newSale.medicine_discount }}</td>
                            <input type="hidden" name="medicine_discount"
                                v-model="newSale.medicine_discount" />
                        </tr>
                        <tr class="d-none">
                            <th>Invoice Discount</th>
                            <td>:</td>
                            <td>
                                <input name="invoice_discount_amount" type="number"
                                    v-model="newSale.invoice_discount_amount" />
                                <select name="invoice_discount_type" v-model="newSale.invoice_discount_type">
                                    <option value="percent">%</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </td>
                        </tr>
                        <tr >
                            <th>Total</th>
                            <td>:</td>
                            <td>{{ newSale.total }}</td>
                            <input type="hidden" id="totalAmount" name="total" v-model="newSale.total" />
                        </tr>
                        <tr>
                            <th>Margin</th>
                            <td>:</td>
                            <td>{{ newSale.margin }}</td>
                            <input type="hidden" id="totalAmount" name="total" v-model="newSale.total" />
                        </tr>
                        <tr>
                            <th>Paid Amount</th>
                            <td>:</td>
                            <td class="fillable px-2">
                                <input type="number" name="paid" v-model="newSale.paid" />
                            </td>
                        </tr>
                        <tr  class="table-sm">
                            <th>Due Amount</th>
                            <td>:</td>
                            <td>
                                <input id="dueAmount" type="number" name="due" v-model="newSale.due"
                                    disabled />
                            </td>
                        </tr>
                        <tr :class="{ 'bg-danger': allErrors.has('sale.payment_method_id') }">
                            <th>Payment Method</th>
                            <td>:</td>
                            <td class="fillable px-2">
                                <select name="payment_method_id" v-model="newSale.payment_method_id">
                                    <option v-for="method in paymentMethods" :value="method.id"
                                        :key="method.id">{{
                                            method.name }}</option>
                                </select>

                            </td>
                            <input type="hidden" name="total_quantity" v-model="newSale.total_quantity" />
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button @click="submitForm"
                                    class="form-control bg-dark text-light">Submit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
             </div>
            </template>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import _ from "lodash";
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';
export default {
    data() {
        return {
            invoice: "",
            sale: {
                result: {
                    sale_details: [],
                    sale_payment: [],
                    customer: {},
                    sale_return: [],
                },
            },
            exchange: {
                products: [],
                total: 0,
            },
            //new sale
            allErrors: new Errors(),
            medicine_barcode: '',
            medicine_name: '',
            saleProducts: [],
            paymentMethod: [],
            newSale: {
                sale_id: null,
                subtotal: parseFloat(Math.round(0)).toFixed(2),
                medicine_discount: parseFloat(Math.round(0)).toFixed(2),
                total: parseFloat(Math.round(0)).toFixed(2),
                invoice_discount_amount: parseFloat(Math.round(0)).toFixed(2),
                paid: parseFloat(Math.round(0)).toFixed(2),
                due: parseFloat(Math.round(0)).toFixed(2),
                total_quantity: 0,
                payment_method_id: 0,
                invoice_discount_type: 'percent',
                margin:parseFloat(Math.round(0)).toFixed(2)
            },
            searchMedicine: [],
        };
    },
    watch: {
        medicine_barcode: _.debounce(function () {
            this.getproductByBarcode();
        }, 500),
        medicine_name: _.debounce(function () {
            this.getproductByDetails();
        }, 500),
        saleProducts: {
            handler: function () {
                this.calculateFields();
            },
            deep: true
        }, 'newSale.invoice_discount_amount': function () {
            this.calculateFields();
        },
        'newSale.invoice_discount_type': function () {
            this.calculateFields();
        },
        'newSale.paid': function (newValue) {
            if (newValue > this.newSale.total) {
                this.newSale.paid = this.newSale.total;
                toastr.error("Paid Amount not getter then payable amount")
            }
            this.calculateFields();
        }
    },
    methods: {
        getInvoice() {
            axios
                .get("/sale/invoice/" + this.invoice)
                .then((response) => {
                    this.sale = response.data;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        exchangeProducts(index, product) {
            const existingProductIndex = this.exchange.products.findIndex(p => p.barcode === product.medicine.barcode);

            if (existingProductIndex === -1) {
                // If the product is not already in the exchange array, add it with quantity 1
                const newProduct = {
                    detail_id:product.id,
                    barcode: product.medicine.barcode,
                    name: product.medicine.name,
                    expire_date: product.expire_date,
                    mrp: product.mrp,
                    quantity: 1, // Start quantity from 1
                    subtotal: product.mrp, // Initial subtotal based on quantity 1
                    discount: product.discount,
                    current_quantity: product.current_quantity,
                };

                // Calculate the total after applying the discount percentage
                newProduct.total = Math.round(newProduct.subtotal - (newProduct.subtotal * newProduct.discount / 100));

                this.exchange.products.push(newProduct);
                this.exchange.total = Math.round(this.exchange.products.reduce((sum, product) => sum + product.total, 0));
                // Increment quantity by 1 in the sale array
                this.sale.result.sale_details[index].current_quantity -= 1;
            } else {
                // If the product is already in the exchange array, update its quantity
                this.exchange.products[existingProductIndex].quantity += 1;

                // Update the subtotal and total based on the increased quantity
                this.exchange.products[existingProductIndex].subtotal = Math.round(this.exchange.products[existingProductIndex].quantity * product.mrp);
                this.exchange.products[existingProductIndex].total = Math.round(this.exchange.products[existingProductIndex].subtotal - (this.exchange.products[existingProductIndex].subtotal * this.exchange.products[existingProductIndex].discount / 100));

                // Increment quantity by 1 in the sale array
                this.sale.result.sale_details[index].current_quantity -= 1;
            }
            this.exchange.total = Math.round(this.exchange.products.reduce((sum, product) => sum + product.total, 0));
        },
        removeProducts(index) {
            if (index >= 0 && index < this.exchange.products.length) {
                // Decrease the quantity by 1 in exchange.products
                this.exchange.products[index].quantity -= 1;

                // Recalculate subtotal based on the decreased quantity
                this.exchange.products[index].subtotal = Math.round(this.exchange.products[index].quantity * this.exchange.products[index].mrp);

                // Recalculate total after applying the discount percentage
                this.exchange.products[index].total =Math.round(this.exchange.products[index].subtotal - (this.exchange.products[index].subtotal * this.exchange.products[index].discount / 100));
                this.exchange.total = Math.round(this.exchange.products.reduce((sum, product) => sum + product.total, 0));
                // Incress the current_quantity by 1 in sale.result.sale_details
                this.sale.result.sale_details[index].current_quantity += 1;
                if (this.exchange.products[index].quantity == 0) {
                    this.exchange.products.splice(index, 1);
                }
            }
        },
        addProduct(product) {
            this.saleProducts.push(product);
        },
        getproductByBarcode: _.debounce(function () {
            if(this.medicine_barcode != null){
                axios
                .get(`medicine-stock-by-barcode/${this.medicine_barcode}`)
                .then((response) => {
                    if (response?.data) {
                        const { barcode, name, id, stock_by_batch } = response.data.result;
                        const existingProduct = this.saleProducts.find(
                            (product) => product.barcode === barcode
                        );

                        if (existingProduct) {
                            existingProduct.quantity += 1;
                            toastr.success("Update Requested product quantity");
                        }  else {
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
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
            }
        }, 500),
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
                product.total = (product.subtotal - (product.subtotal * product.discount / 100)).toFixed(2);
                subtotal += parseFloat(product.total);
                medicineDiscount += (product.subtotal - product.total);
                totalQuantity += parseInt(product.quantity);
                if (product.available < product.quantity) {
                    product.quantity = product.available
                    toastr.error('Stock is not available');
                }
            });

            this.newSale.subtotal = subtotal.toFixed(2);
            this.newSale.medicine_discount = medicineDiscount.toFixed(2);
            this.newSale.total = (this.newSale.invoice_discount_type === 'percent')
                ? (subtotal - (subtotal * parseFloat(this.newSale.invoice_discount_amount) / 100)).toFixed(2)
                : (subtotal - parseFloat(this.newSale.invoice_discount_amount || 0)).toFixed(2);
            this.newSale.total = parseFloat(this.newSale.total);
            this.newSale.margin =parseFloat(this.newSale.total - this.exchange.total);
            // Round the total to the nearest whole number
            this.newSale.total = Math.round(this.newSale.total);
            this.newSale.due = (this.newSale.margin - this.newSale.paid).toFixed(2);
            this.newSale.total_quantity = parseInt(totalQuantity);
        },
        getPaymentMethods() {
            axios
                .get('/payment-method', { params: { paginate: true } })
                .then((response) => {
                    this.paymentMethods = response.data.result;
                    const cash = this.paymentMethods.find(account => account.name === 'Cash');
                    if(cash){
                      this.newSale.payment_method_id = cash.id
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        getMRPByExpireDate(product) {
            // Call the API get-stock-by-expiredate passing the selected expire_date and medicine_id
            axios
                .get('get-stock-by-expiredate', { params: { medicine_id: product.id, expire_date: product.expire_date } })
                .then((response) => {
                    if (response?.data?.result) {
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
                        toastr.error('Invalid response received from get-stock-by-expiredate API');
                    }
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
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
                        is_exchange:1,
                        total: product.total
                    };
                });
                const exchangeData = this.exchange.products.map((product) => {
                    return {
                        detail_id: product.detail_id,
                        quantity: product.quantity,
                        price: product.total,
                        customer_id :this.sale.result.customer.id
                    };
                });
                this.newSale.customer_id = this.sale.result.customer.id;
                this.newSale.sale_id = this.sale.result.id;

                const formData = {
                    saleProducts: productsData,
                    sale: this.newSale,
                    exchange:exchangeData,
                };
                console.log(formData);
                // // Make the POST request and wait for the response
                const response = await axios.post('sale-exchange', formData);
                handleSuccessResponse.call(this, response);
                // // Reset saleProducts and sale data
                this.saleProducts = [];
                this.newSale  = {
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
                // // Print after the data is fully updated
                this.$router.push({ name: 'sale.view',params:{ id:this.sale.result.id }});
                await this.$nextTick(); // Ensure DOM updates before printing
            } catch (error) {
                // Handle the error response
                handleErrorResponse.call(this, error);
            }
        },

        addToBarcode($barcode) {
            this.medicine_barcode = $barcode;
            this.medicine_name = '';
        },
        clearError(fieldName) {
            // Assuming allErrors is a reactive object with properties corresponding to field names
            this.allErrors.errors[fieldName] = null;
            console.log(this.allErrors);
        },
    },
    created() {
        this.getPaymentMethods();
    },
};
</script>
<style>
.table-sm td input {
    max-width: 100px;
}

.table-sm> :not(caption)>*>* {
    padding: 0px;
}
/* .dis,
.qty,
.mrp {
    width: 60px;
} */

.name {
    width: 200px;
}
#vertical-example {
    overflow-y: auto;
    max-height: 500px;
}
.items {
    padding-top: 2px;
    position: absolute;
    max-height: 80vh !important;
    overflow-y: scroll;
    background: rgba(232, 232, 232, 0.8);
    backdrop-filter: blur(1px);
}
.table-sm td input {
    max-width: 100px;
    background-color: transparent;
    border: none !important;
    text-align: center;
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
</style>
