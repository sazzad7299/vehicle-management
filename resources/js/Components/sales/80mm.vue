<template lang="">
    <div>
        <section
                style="width: 302px; margin: 10px auto;background-color: #fff; padding:5px;margin-bottom: 70px;height: auto;"
                id="invoiceArea">
                <header style="text-align: center; padding-bottom: 0px">
                    <h2 style="font-size: 24px; font-weight: 700; margin: 0; padding: 0;">{{ user.pharmacy.company_name }}</h2>
                    <div style="margin-bottom: 5px; line-height: 1;">
                        <span style="font-size: 12px;">{{ user.pharmacy.street_address }}</span>
                        <div style="display: block;text-align:center">
                            <span style="font-size: 12px;">Mobile: {{ user.pharmacy.mobile_no }}</span>
                        </div>
                    </div>
                </header>
                -----------------------------------------------------

                <section style="font-size: 12px;  line-height: 1.222;">
                    <table style="width: 100%;">
                        <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td class="w-30" style="font-size:12px"><span style="font-size:12px"><b>Date:</b>
                                </span>
                            </td>
                            <td style="font-size:12px">30 Nov, 2023</td>
                        </tr>
                        <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td class="w-30" style="font-size:12px"><span style="font-size:12px"><b>Invoice
                                        ID:</b></span>
                            </td>
                            <td style="font-size:12px">{{ saleData.result.invoice }}</td>
                        </tr>

                        <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td class="w-30" style="font-size:12px"><b>Customer Name:</b></td>
                            <td style="font-size:12px">{{ saleData.result.customer.name }}</td>
                        </tr>
                    </table>
                </section>

                <h4 style="font-size: 18px;font-weight: 700;text-align: center;margin: 5px 0 0px 0;padding: 0px 0;">INVOICE
                </h4>
                -----------------------------------------------------
                <section style="line-height: 1.23;">
                    <table style="width: 100%">
                        <thead>
                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000; font-weight: 700;">
                                <th class="w-10 text-center" style="font-size: 12px; text-align: center">Sl.</th>
                                <th class="w-40" style="font-size: 12px;">Name</th>
                                <th class="w-15 text-center" style="font-size: 12px; text-align: center">Qty</th>
                                <th class="w-15 text-right" style="font-size: 12px; text-align: center">Price</th>
                                <th class="w-20 text-right"
                                    style="border-bottom: none; font-size: 12px; text-align: center">Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;" v-for="(product, index) in saleData.result.sale_details" :key="index">
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ index + 1 }}
                                </td>
                                <td style="vertical-align: top; font-size: 12px">{{ product.medicine.name }}</td>
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.quantity }}</td>
                                <td class="text-right" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.mrp }}</td>
                                <td class="text-right"
                                    style="border-bottom: none;vertical-align: top;font-size: 12px;text-align: center ">
                                    {{ product.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <section style="line-height: 1.23;" v-if="saleData.result.sale_exchange.length >0">
                    <p style="font-size:12px;margin:0;font-weight: 700;">Sale Exchange</p>
                    <table style="width: 100%">
                        <thead>
                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000; font-weight: 700;">
                                <th class="w-10 text-center" style="font-size: 12px; text-align: center">Sl.</th>
                                <th class="w-40" style="font-size: 12px;">Name</th>
                                <th class="w-15 text-center" style="font-size: 12px; text-align: center">Qty</th>
                                <th class="w-15 text-right" style="font-size: 12px; text-align: center">Price</th>
                                <th class="w-20 text-right"
                                    style="border-bottom: none; font-size: 12px; text-align: center">Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;" v-for="(product, index) in saleData.result.sale_exchange" :key="index">
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ index + 1 }}
                                </td>
                                <td style="vertical-align: top; font-size: 12px">{{ product.medicine.name }}</td>
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.quantity }}</td>
                                <td class="text-right" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.mrp }}</td>
                                <td class="text-right"
                                    style="border-bottom: none;vertical-align: top;font-size: 12px;text-align: center ">
                                    {{ product.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <section style="line-height: 1.23;" v-if="saleData.result.sale_return.length>0">
                    -----------------------------------------------------
                    <p style="font-size:12px;margin:0;font-weight: 700;">Sale Return</p>
                    <table style="width: 100%">
                        <thead>
                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000; font-weight: 700;">
                                <th class="w-10 text-center" style="font-size: 12px; text-align: center">Sl.</th>
                                <th class="w-40" style="font-size: 12px;">Name</th>
                                <th class="w-15 text-center" style="font-size: 12px; text-align: center">Qty</th>
                                <th class="w-15 text-right" style="font-size: 12px; text-align: center">Price</th>
                                <th class="w-20 text-right"
                                    style="border-bottom: none; font-size: 12px; text-align: center">Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr style="border-top: 1px solid #000; border-bottom: 1px solid #000;" v-for="(product, index) in saleData.result.sale_return" :key="index">
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ index + 1 }}
                                </td>
                                <td style="vertical-align: top; font-size: 12px">{{ product.medicine.name }}</td>
                                <td class="text-center" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.quantity }}</td>
                                <td class="text-right" style="vertical-align: top; font-size: 12px; text-align: center">{{ product.price }}</td>
                                <td class="text-right"
                                    style="border-bottom: none;vertical-align: top;font-size: 12px;text-align: center ">
                                    {{ product.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <section style="line-height: 1.23; font-size: 12px; border-top: 1px solid #000;">
                    <table style="width: 100%">
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td style="text-align: right; font-size: 12px; width: 70%">Sub Total:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">{{ saleData.result.subtotal? saleData.result.subtotal:0 }}</td>
                        </tr>
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;" v-if="saleData.result.returnable_price > 0">
                            <td style="text-align: right; font-size: 12px; width: 70%">Return Price:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">{{ saleData.result.returnable_price? saleData.result.returnable_price:0 }}</td>
                        </tr>
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td style="text-align: right; font-size: 12px; width: 70%">Discount:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">{{ saleData.result.medicine_discount?saleData.result.medicine_discount:0 }}</td>
                        </tr>
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td style="text-align: right; font-size: 12px; width: 70%">Vat:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">0.00</td>
                        </tr>
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td style="text-align: right; font-size: 12px; width: 70%">Grand Total:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">{{ saleData.result.total  - saleData.result.returnable_price}}</td>
                        </tr>
                        <tr style=" border-top: 1px solid #000; border-bottom: 1px solid #000;">
                            <td style="text-align: right; font-size: 12px; width: 70%">Due:</td>
                            <td style="text-align: right; font-size: 12px; width: 70%">{{ totalDue }}</td>
                        </tr>
                    </table>
                </section>
                -----------------------------------------------------
                <section style="line-height: 1.222; font-size: 12px; font-style: italic; padding: 0px 0">
                    <span style="line-height: 1.222; font-size: 12px; font-style: italic; text-transform:capitalize"><b>In Text:</b> {{ saleData.result.numberTotext }} TK Only</span><br>
                </section>
                -----------------------------------------------------
                <section style="line-height: 1.222;">
                    <div style=" position: relative;">
                        <h2 style="font-size: 12px;  font-weight: 700;  margin: 0px 0 0px 0;">Payments</h2>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td style="font-size: 12px;">-RECEIVED PAYMENT</td>
                            <td style="font-size: 12px;text-align: right;">{{ saleData.result.total_paid?saleData.result.total_paid : 0 }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;">-RETURNED AMOUNT</td>
                            <td style="font-size: 12px;text-align: right;">{{ saleData.result.return_price}}</td>
                        </tr>
                    </table>
                </section>
                -----------------------------------------------------

                <section style="font-size: 12px; line-height: 1.222; text-align: center; padding-top: 0px">
                    <span style="display: block; font-weight: 700;">Thank you for choosing us!</span>
                    <span style="display: block;">Software Developed By Amarlodge Limited. www.amarlodge.com</span>
                </section>
            </section>
    </div>
</template>
<script>
import {userStore} from "../../stores/user";
export default {
    props:{
        saleData: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            user:null,
        }
    },
    computed: {
        totalDue() {
            const total = this.saleData.result.total;
            const totalPaid = this.saleData.result.total_paid;
            const returnable_price = this.saleData.result.returnable_price;
            const return_price = this.saleData.result.return_price;
            const dueAmount = total + return_price - totalPaid - returnable_price;
            return dueAmount;
        },

    },
    created(){
        const userInfo = userStore();
        this.user = userInfo.user;
        console.log(this.saleData.result);
    }
}
</script>
<style lang="">

</style>
