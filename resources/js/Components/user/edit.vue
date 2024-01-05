<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit User /</span>
            <router-link :to="{name: 'user.index'}">
                User List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Edit User</h5>
                    <div class="card-body">
                        <form @submit.prevent="updateUser" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                           autocomplete="off" v-model="user.name">
                                    <span v-if="this.allErrors.has('name')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Email<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Email" name="email"
                                           autocomplete="off" v-model="user.email">
                                    <span v-if="this.allErrors.has('email')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                           autocomplete="off" v-model="user.phone">
                                    <span v-if="this.allErrors.has('phone')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3" v-if="isPharmacy == 'null'">
                                    <label class="form-label" for="basic-default-name">Pharmacy
                                        <span class="text-danger">*</span>
                                    </label>
                                    <v-select
                                        :options="pharmacies"
                                        :label="'company_name'"
                                        name="pharmacy_id"
                                        :placeholder="'Select Pharmacy'"
                                        :reduce="country => country.id"
                                        :loading="Loader.pharmacy"
                                        v-model="user.pharmacy_id"
                                        @update:modelValue="this.allErrors.clear(`pharmacy_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('pharmacy_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('pharmacy_id')">
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
                                              v-model="user.country_id"
                                              @update:modelValue="this.allErrors.clear(`country_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('country_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('country_id')">
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
                                              v-model="user.division_id"
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
                                              v-model="user.district_id"
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
                                              v-model="user.upazilas_id"
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
                                              v-model="user.union_id"
                                              @update:modelValue="this.allErrors.clear('union_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('union_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('union_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Role Assign <span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="roles"
                                              :label="'name'"
                                              name="role_id"
                                              :placeholder="'Select Role'"
                                              :reduce="role => role.id"
                                              :loading="Loader.role"
                                              v-model="user.role_id"
                                              @update:modelValue="this.allErrors.clear('role_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('role_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('role_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Zip Code<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Zip Code" name="zip_code"
                                           autocomplete="off" v-model="user.zip_code">
                                    <span v-if="this.allErrors.has('zip_code')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('zip_code')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Image<span
                                            class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="user_image"
                                        @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('image')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('image')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                        <input class="form-check-input switch-lg" type="checkbox" v-model="user.user_status">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="user_image ? user_image : '/images/blank.jpg'"
                                            alt="Card image cap">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="d-grid gap-2 col-lg-1 mx-auto">
                                    <button class="btn btn-primary" type="submit">Update</button>
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

export default {
    name: "Edit user",
    data() {
        return {
            allErrors: new Errors(),
            user: {},
            user_image: '',
            pharmacies: [],
            countries: [],
            divisions: [],
            districts: [],
            upazilas: [],
            unions: [],
            roles: [],
            Loader: {
                pharmacy: false,
                country: false,
                division: false,
                district: false,
                upzila: false,
                union: false,
                role: false,
            },
            isPharmacy: null,
        }
    },
    watch: {
        'user.country_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.division_id = '';
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
                return;
            }
            this.getDivisionList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.user.division_id = '';
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
            }
        },
        'user.division_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
                return;
            }

            this.getDistrictList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
            }
        },
        'user.district_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.upazilas_id = '';
                return;
            }
            this.getUpzilaList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.user.upazilas_id = '';
                this.user.union_id = '';
            }
        },
        'user.upazilas_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.union_id = '';
                return;
            }
            this.getUnionList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.user.union_id = '';
            }
        },
    },
    methods: {
        getUser() {
            axios.get('user/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.user = response.data.result
                    if (this.user.image)
                        this.user_image = '/' + this.user.image;
                        this.user.image = null;
                    if(this.user.user_status ==1){
                        this.user.user_status = true
                    }else{
                        this.user.user_status = false
                    }
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        updateUser() {
            this.loader(true);
            console.log(this.user);
            axios.put('user/' + this.user.id, {
                ...this.user    
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({name: 'user.index'});
                    }
                })
                .catch(error => {
                    this.loader(false);
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                })
        },
        getPharmacy() {
            this.Loader.pharmacy = true;
            axios.get('get-user-pharmacy')
                .then(response => {
                    setTimeout(() => {
                        this.Loader.pharmacy = false;
                    }, 500);
                    this.pharmacies = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        getRole() {
            this.Loader.role = true;
            axios.get('rbac/get-roles')
                .then(response => {
                    setTimeout(() => {
                        this.Loader.role = false;
                    }, 500);
                    this.roles = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
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
            axios.get('country-wise-division/' + this.user.country_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.division = false;
                    }, 500);

                    this.divisions = response.data.result;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getDistrictList() {
            this.Loader.district = true;
            axios.get('division-wise-district/' + this.user.division_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.district = false;
                    }, 500);
                    this.districts = response.data.result;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getUpzilaList() {
            this.Loader.upzila = true;
            axios.get('district-wise-upzila/' + this.user.district_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.upzila = false;
                    }, 500);
                    this.upazilas = response.data.result;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getUnionList() {
            this.Loader.union = true;
            axios.get('upzila-wise-union/' + this.user.upazilas_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.union = false;
                    }, 500);
                    this.unions = response.data.result;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.user.image = event.target.result;
                this.user_image = this.user.image;
            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {
        this.getCountry();
        this.getPharmacy();
        this.getRole();
    },
    created() {
        this.getUser();
       this.isPharmacy = localStorage.getItem('PharmacyUser');
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
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}
</style>
