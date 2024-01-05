<!-- EnterUserData.vue -->
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
                                         autocomplete="off" v-model="user.company_name">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Mobile<span
                                      class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" placeholder="Mobile" name="mobile_no"
                                         autocomplete="off" v-model="user.mobile_no">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Website<span class="text-danger">*</span>
                                  </label>
                                  <input type="text" class="form-control" placeholder="Website" name="website"
                                         autocomplete="off" v-model="user.website">
                              </div>
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Street Address<span
                                      class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" placeholder="Street Address"
                                         name="street_address"
                                         autocomplete="off" v-model="user.street_address">
                              </div>
                             
                              <div class="mb-3 col-md-6 col-sm-12">
                                  <label class="form-label" for="basic-default-name">Logo<span
                                      class="text-danger">*</span> </label>
                                  <input type="file" class="form-control" placeholder="Note" name="logo"
                                         @change="onFileChange($event)">
                              </div>
                              <div class="mb-3 text-center">
                                  <div class="image-container">
                                      <img :src="user.logo ? user.logo : '/images/blank.jpg'"
                                           class="rounded-circle img-preview" alt="">
                                  </div>
                              </div>
                          </div>
                          <div class="row justify-content-center">
                              <div class="d-grid gap-2 col-lg-1 mx-auto">
                                  <button class="btn btn-primary" type="button"  @click="prevStep">Back</button>
                              </div>  
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
  props: {
    dataUser: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      user: this.dataUser ? this.dataUser : {}
    };
  },
  methods: {
    nextStep() {
      this.$emit("nextStep", { user: this.user });
      console.log(this.user);
    },
    prevStep() {
      this.$emit("prevStep");
    },
  },
};
</script>
