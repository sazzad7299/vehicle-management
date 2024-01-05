<!-- SelectPharmacy.vue -->
<template>
  <div>
    <h2>Select Pharmacy</h2>
    <form @submit.prevent="nextStep">
      <label for="pharmacy">Pharmacy Name:</label>
      <input v-model="pharmacy.name" type="text" required />
      <input v-model="pharmacy.email" type="email" required />
      <input v-model="pharmacy.phone" type="number" required />
      <button type="submit">Next</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    datapharmacy:{
        type: Object,
        required: true,
      }
  },
  data() {
    return {
      pharmacy: this.datapharmacy ? this.datapharmacy  : {},
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep", { pharmacy: this.pharmacy });
      console.log(this.pharmacy);
    }
  },
};
</script>
