<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Create Pharmacy /</span>
            <router-link :to="{name: 'pharmacy.index'}">
                Pharmacy List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Create Pharmacy</h5>
                    <div class="card-body">
                        <form @submit.prevent="createPharmacy" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="company_name"
                                           autocomplete="off" v-model="pharmacy.company_name">
                                    <span v-if="this.allErrors.has('company_name')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('company_name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Mobile<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Mobile" name="mobile_no"
                                           autocomplete="off" v-model="pharmacy.mobile_no">
                                    <span v-if="this.allErrors.has('mobile_no')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('mobile_no')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Website<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Website" name="website"
                                           autocomplete="off" v-model="pharmacy.website">
                                    <span v-if="this.allErrors.has('website')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('website')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Country
                                        <span class="text-danger">*</span>
                                    </label>
                                    <v-select :options="countries"
                                              :label="'name'"
                                              name="country"
                                              :placeholder="'Select Country'"
                                              :reduce="country => country.id"
                                              :loading="Loader.country"
                                              v-model="pharmacy.country"
                                              @update:modelValue="this.allErrors.clear(`country`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('country')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('country')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Division<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="divisions"
                                              :label="'name'"
                                              name="division_id"
                                              :placeholder="'Select Division'"
                                              :reduce="division => division.id"
                                              :loading="Loader.division"
                                              v-model="pharmacy.division_id"
                                              @update:modelValue="this.allErrors.clear('division_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('division_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('division_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">District<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="districts"
                                              :label="'name'"
                                              name="district_id"
                                              :placeholder="'Select District'"
                                              :reduce="district => district.id"
                                              :loading="Loader.district"
                                              v-model="pharmacy.district_id"
                                              @update:modelValue="this.allErrors.clear('district_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('district_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('district_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Upzila<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="upazilas"
                                              :label="'name'"
                                              name="upazilas_id"
                                              :placeholder="'Select Upzila'"
                                              :reduce="upzila => upzila.id"
                                              :loading="Loader.upzila"
                                              v-model="pharmacy.upazilas_id"
                                              @update:modelValue="this.allErrors.clear('upazilas_id')">
                                    </v-select>

                                    <span v-if="this.allErrors.has('upazilas_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('upazilas_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Union <span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="unions"
                                              :label="'name'"
                                              name="union_id"
                                              :placeholder="'Select Union'"
                                              :reduce="union => union.id"
                                              :loading="Loader.union"
                                              v-model="pharmacy.union_id"
                                              @update:modelValue="this.allErrors.clear('union_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('union_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('union_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Zip Code<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Zip Code" name="zip_code"
                                           autocomplete="off" v-model="pharmacy.zip_code">
                                    <span v-if="this.allErrors.has('zip_code')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('zip_code')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Street Address<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Street Address"
                                           name="street_address"
                                           autocomplete="off" v-model="pharmacy.street_address">
                                    <span v-if="this.allErrors.has('street_address')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('street_address')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Google Map Location<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Google Map Location"
                                           name="google_map_location"
                                           autocomplete="off" v-model="pharmacy.google_map_location">
                                    <span v-if="this.allErrors.has('google_map_location')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('google_map_location')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Refer Name<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Refer Name"
                                           name="reffer_by_name"
                                           autocomplete="off" v-model="pharmacy.reffer_by_name">
                                    <span v-if="this.allErrors.has('reffer_by_name')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('reffer_by_name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Refer Phone <span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Refer Phone"
                                           name="reffer_by_phone"
                                           autocomplete="off" v-model="pharmacy.reffer_by_phone">
                                    <span v-if="this.allErrors.has('reffer_by_phone')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('reffer_by_phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Note<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Note" name="note"
                                           autocomplete="off" v-model="pharmacy.note">
                                    <span v-if="this.allErrors.has('note')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('note')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Subscribe Plan<span
                                        class="text-danger">*</span> </label>
                                    
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Logo<span
                                        class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="logo"
                                           @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('logo')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('logo')">
                                    </span>
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
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../errors/errors";
import {userStore} from "../../stores/user";

export default {
    name: "Create Pharmacy",
    data() {
        const store = userStore();
        return {
            allErrors: new Errors(),
            pharmacy: {
                user_id: store.user.id,
                company_name: '',
                mobile_no: '',
                logo: '',
                website: '',
                country: '',
                division_id: '',
                district_id: '',
                upazilas_id: '',
                union_id: '',
                zip_code: '',
                street_address: '',
                google_map_location: '',
                reffer_by_name: '',
                reffer_by_phone: '',
                note: '',
                status: '',
            },
            countries: [],
            divisions: [],
            districts: [],
            upazilas: [],
            unions: [],
            Loader: {
                country: false,
                division: false,
                district: false,
                upzila: false,
                union: false,
            }
        }
    },
    watch: {
        'pharmacy.country': function (newVal, oldVal) {
            
            if (newVal === null) {
                this.pharmacy.division_id = '';
                this.pharmacy.district_id = '';
                this.pharmacy.upazilas_id = '';
                this.pharmacy.union_id = '';
                return;
            }
            this.pharmacy.division_id = '';
            this.pharmacy.district_id = '';
            this.pharmacy.upazilas_id = '';
            this.pharmacy.union_id = '';
            this.getDivisionList();
        },
        'pharmacy.division_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.pharmacy.district_id = '';
                this.pharmacy.upazilas_id = '';
                this.pharmacy.union_id = '';
                return;
            }
            this.pharmacy.district_id = '';
            this.pharmacy.upazilas_id = '';
            this.pharmacy.union_id = '';
            this.getDistrictList();
        },
        'pharmacy.district_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.pharmacy.upazilas_id = '';
                return;
            }
            this.pharmacy.upazilas_id = '';
            this.getUpzilaList();
        },
        'pharmacy.upazilas_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.pharmacy.union_id = '';
                return;
            }
            this.getUnionList();
        },
    },
    methods: {
        createPharmacy() {
            this.loader(true);
            axios.post('pharmacy', {
                ...this.pharmacy
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({name: 'pharmacy.index'});
                    }
                })
                .catch(error => {
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                        this.loader();
                    }
                    if (error && error.response.status === 422) {
                        this.loader(false);
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                })
        },
        getCountry() {
            this.Loader.country = true;
            axios.get('country')
                .then(response => {
                    this.Loader.country = false;
                    this.countries = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        getDivisionList() {
            this.Loader.division = true;
            axios.get('country-wise-division/' + this.pharmacy.country)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.division = false;
                    }, 500);

                    this.divisions = response.data.result;
                })
                .catch(error => {
                   toastr.error("Failed to load")
                })
        },
        getDistrictList() {
            this.Loader.district = true;
            axios.get('division-wise-district/' + this.pharmacy.division_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.district = false;
                    }, 500);
                    this.districts = response.data.result;
                })
                .catch(error => {
                    toastr.error("Failed to load")
                })
        },
        getUpzilaList() {
            this.Loader.upzila = true;
            axios.get('district-wise-upzila/' + this.pharmacy.district_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.upzila = false;
                    }, 500);
                    this.upazilas = response.data.result;
                })
                .catch(error => {
                    toastr.error("Failed to load")
                })
        },
        getUnionList() {
            this.Loader.union = true;
            axios.get('upzila-wise-union/' + this.pharmacy.upazilas_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.union = false;
                    }, 500);
                    this.unions = response.data.result;
                })
                .catch(error => {
                    toastr.error("Failed to load")
                })
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
    mounted() {
        this.getCountry();
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
