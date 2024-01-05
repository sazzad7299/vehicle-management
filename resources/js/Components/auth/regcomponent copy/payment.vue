<!-- SelectPaymentOption.vue -->
<template>
  <div>
    <h2>Select Payment Option</h2>
    <form @submit.prevent="submitForm">
      <label for="payment">Payment Option:</label>
      <input v-model="paymentOption" type="text" required />
      <button type="submit">Submit</button>
      <button type="button" @click="prevStep">Previous</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      paymentOption: "",
    };
  },
  methods: {
    submitForm() {
      this.$emit("submitForm", { paymentOption: this.paymentOption });
    },
    prevStep() {
      this.$emit("prevStep");
    },
  },
};
</script>
