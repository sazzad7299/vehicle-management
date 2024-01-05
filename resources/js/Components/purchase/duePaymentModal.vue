<template>
  <div class="modal fade" id="paymentCollectionModal" tabindex="-1" aria-labelledby="paymentCollectionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentCollectionModalLabel">Payment Collection</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
        </div>
        <form @submit.prevent="handlePayment" @keydown="allErrors.clear($event.target.name)">
          <div class="modal-body">
              <input type="text" class="form-control" :value="purchaseId" hidden/>
            <div class="form-group">
              <label for="paymentMethod">Payment Method</label>
              <select class="form-control" v-model="paymentMethodId" :name="fieldName('payment_method_id')">
                <option value="" disabled selected>Select Payment Method</option>
                <option v-for="method in paymentMethods" :key="method.id" :value="method.id">{{ method.name }}</option>
              </select>
              <span v-if="hasError('payment_method_id')" class="error text-danger fw-semibold mt-3">{{
                getError('payment_method_id') }}</span>
            </div>
            <div class="form-group">
              <label for="paid">Paid Amount</label>
              <input type="number" class="form-control" v-model="paid" name="paid" />
              <span v-if="hasError('paid')" class="error text-danger fw-semibold mt-3">{{ getError('paid') }}</span>
            </div>
            <div class="form-group d-none">
              <label for="discount">Discount</label>
              <input type="number" class="form-control" v-model="discount" name="discount" />
            </div>
            <div class="form-group">
              <label for="dueAmount">Due Amount</label>
              <input type="number" class="form-control" :value="calculateDueAmount" readonly />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary">Pay</button>
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
import { toDisplayString } from "vue";

export default {
  props: {
    purchaseId: {
      type: String,
      required: true
    },
    dueAmount: {
      type: Number,
      required: true
    },
    paymentMethods:{
      type:Object,
      required:true,
    }
  },
  data() {
    return {
      allErrors: new Errors(),
      paymentMethodId: '',
      paid: 0,
      discount: 0,
    };
  },
 methods: {
    fieldName(fieldName) {
      return `paymentCollection[${fieldName}]`;
    },
    hasError(fieldName) {
      return this.allErrors.has(fieldName);
    },
    getError(fieldName) {
      return this.allErrors.get(fieldName);
    },
    handlePayment() {
      this.loader(true);
      const data = {
        purchase_id: this.purchaseId,
        payment_method_id: this.paymentMethodId,
        paid: this.paid,
        discount: this.discount,
      };
      axios.post('purchase-payment', data)
        .then((response) => {
          this.loader(false);
          handleSuccessResponse.call(this, response);
          this.$emit('payment-success');
          $('#paymentCollectionModal').modal('hide');
          this.paymentMethodId = '';
          this.paid = 0;
          this.discount = 0;
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
    clearData(){
      this.paymentMethodId='';
      this.paid= 0;
      this.discount= 0;
    }
  },
  computed: {
    calculateDueAmount() {
      const total = parseFloat(this.dueAmount);
      const paid = parseFloat(this.paid);
      const discount = parseFloat(this.discount);
      let due = total - (paid + discount);
      if(due< 0){
        this.paid = total;
        toastr.warning(`You Cann't paid more then ${total} Tk`);
      }
           
      return Math.max(due, 0);
    }
  }
};
</script>

<style>
/* Add any necessary styles for the modal here */
/* ... */
</style>
