<template>
    <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="">
      <div class="row justify-content-md-center">
          <div class="col-md-12">
              <div class="card mb-4">
                  <h5 class="card-header fw-bold">Your Store Information</h5>
                  <div class="card-body">
                      <form @submit.prevent="nextStep">
                          <div class="row">
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Name<span
                                      class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" placeholder="Name" name="company_name"
                                         autocomplete="off" v-model="pharmacy.company_name">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Mobile<span
                                      class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" placeholder="Mobile" name="mobile_no"
                                         autocomplete="off" v-model="pharmacy.mobile_no">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Website<span class="text-danger">*</span>
                                  </label>
                                  <input type="text" class="form-control" placeholder="Website" name="website"
                                         autocomplete="off" v-model="pharmacy.website">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Street Address<span
                                      class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" placeholder="Street Address"
                                         name="street_address"
                                         autocomplete="off" v-model="pharmacy.street_address">
                              </div>
                             
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Logo<span
                                      class="text-danger">*</span> </label>
                                  <input type="file" class="form-control" placeholder="Note" name="logo"
                                         @change="onFileChange($event)">
                              </div>
                              <div class="mb-3 text-center">
                                  <div class="image-container">
                                      <img :src="pharmacy.logo ? pharmacy.logo : '/images/blank.jpg'"
                                           class="rounded-circle img-preview" alt="">
                                  </div>
                              </div>
                          </div>
                          <div class="row justify-content-center">
                              <div class="d-grid gap-2 col-lg-1 mx-auto">
                                  <button class="btn btn-primary" type="submit">Next</button>
                              </div>  
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>
     
    </div>
</template>
<script>
export default {
  name: "Create Pharmacy",
  props: {
    datapharmacy:{
        type: Object,
        required: true,
      }
  },
  data() {
      return {
          pharmacy: this.datapharmacy ? this.datapharmacy  :{
              company_name: '',
              mobile_no: '',
              logo: '',
              website: '',
              street_address: '',
          },
  
      }
  },
  methods: {
    nextStep() {
      this.$emit("nextStep", { pharmacy: this.pharmacy });
      console.log(this.pharmacy);
    },
    onFileChange(event) {
          let file = event.target.files[0];
          let reader = new FileReader();
          reader.onload = (event) => {
              this.pharmacy.logo = event.target.result;
          };
          reader.readAsDataURL(file);
      },
  },
}

</script>
<style scoped>
.image-container {
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 10px;
}

.img-preview {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border: 2px solid #ccc;
  border-radius: 50%;
}

</style>
