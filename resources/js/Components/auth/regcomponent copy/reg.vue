
<template>
    <div v-if="currentStep === 1">
    <SelectPharmacy @nextStep="nextStep" :datapharmacy="formData.pharmacy.pharmacy" />
  </div>
  <div v-else-if="currentStep === 2">
    <EnterUserData @nextStep="nextStep" @prevStep="prevStep" :dataUser="formData.userData.user" />
  </div>
  <div v-else-if="currentStep === 3">
    <SelectPaymentOption
      @submitForm="submitForm"
      @prevStep="prevStep"
      :storedData="formData.paymentOption"
    />
  </div>
    <div v-else>
      <h2>Form Submitted Successfully!</h2>
      <pre>{{ submittedData }}</pre>
    </div>

</template>

<script>
import SelectPharmacy from "./regcomponent/pharmacy.vue";
import EnterUserData from "./regcomponent/user.vue";
import SelectPaymentOption from "./regcomponent/payment.vue";

export default {
  name: "App",
  components: {
    SelectPharmacy,
    EnterUserData,
    SelectPaymentOption,
  },
  data() {
    return {
      currentStep: 1,
      formData: {
        pharmacy: {},
        userData: {},
        paymentOption: {},
      },
      submittedData: {},
    };
  },
  methods: {
    nextStep(data) {
      if (this.validateData(data)) {
        if (this.currentStep === 1) {
          this.formData.pharmacy = data;
          // console.log(this.formData);
        } else if (this.currentStep === 2) {
          this.formData.userData = data;
        }
        this.currentStep += 1;
      } else {
        alert("Please fill in all required fields.");
      }
    },
    prevStep() {
      this.currentStep -= 1;
    },
    submitForm(data) {
      if (this.validateData(data)) {
        this.formData.paymentOption = data;
        this.submittedData = this.formData;
        this.currentStep += 1;
      } else {
        alert("Please fill in all required fields.");
      }
    },
    validateData(data) {
      return Object.values(data).every(
        (value) => value !== null && value !== ""
      );
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

h2 {
  color: #27ae60;
}
</style>
