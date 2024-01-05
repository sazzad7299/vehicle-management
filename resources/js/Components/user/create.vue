<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add User /</span>
            <router-link :to="{name: 'user.index'}">
                User List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add User</h5>
                    <div class="card-body">
                        <form @submit.prevent="createUser" @keydown="allErrors.clear($event.target.name)">
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
                                            :reduce="role=>role.id"
                                              :label="'name'"
                                              name="role_id"
                                              :placeholder="'Select Role'"
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
                                    <label class="form-label" for="basic-default-name">Password<span
                                        class="text-danger">*</span> </label>
                                    <input type="password" class="form-control" placeholder="Enter Password"
                                           name="password"
                                           autocomplete="off" v-model="user.password">
                                    <span v-if="this.allErrors.has('password')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('password')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Confirm Password<span
                                        class="text-danger">*</span> </label>
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                           name="password_confirmation"
                                           autocomplete="off" v-model="user.password_confirmation">
                                    <span v-if="this.allErrors.has('password_confirmation')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('password_confirmation')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview" :src="user.image ? user.image : '/images/blank.jpg'"
                                             alt="Card image cap">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Image<span
                                        class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="image"
                                           @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('image')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('image')">
                                    </span>
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
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Create user",
    data() {
        return {
            allErrors: new Errors(),
            user: {
                name: '',
                phone: '',
                pharmacy_id: '',
                email: '',
                password: '',
                password_confirmation: '',
                country_id: '',
                division_id: '',
                district_id: '',
                upazilas_id: '',
                union_id: '',
                role_id: '',
                zip_code: '',
                street_address: '',
                image: '',
            },
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
            isPharmacy: localStorage.getItem('PharmacyUser')
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
            this.user.division_id = '';
            this.user.district_id = '';
            this.user.upazilas_id = '';
            this.user.union_id = '';
            this.getDivisionList();
        },
        'user.division_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
                return;
            }
            this.user.district_id = '';
            this.user.upazilas_id = '';
            this.user.union_id = '';
            this.getDistrictList();
        },
        'user.district_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.upazilas_id = '';
                return;
            }
            this.user.upazilas_id = '';
            this.getUpzilaList();
        },
        'user.upazilas_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.union_id = '';
                return;
            }
            this.getUnionList();
        },
    },
    methods: {
        createUser() {
            this.loader(true);
            axios.post('user', {
                ...this.user
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.$router.push({name: 'user.index'});
                    }
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
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
            axios.get('/rbac/get-roles')
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
                    handleErrorResponse.call(this, error);
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
                    toastr.error(error.message);
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
                    toastr.error(error.message);
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
                    toastr.error(error.message);
                })
        },
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.user.image = event.target.result;
            };
            reader.readAsDataURL(file);
        },
        fetchCreateData(model) {
            axios.get("check-store", {
                params: {
                    model: model
                }
            })
                .then((response) => {
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                    this.$router.push({name: 'user.index'});
                   
                });
        }
    },
    mounted() {
        this.getCountry();
        this.getPharmacy();
        this.getRole();
    },
    created(){
        this.fetchCreateData('App\\Models\\User');
    }
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
