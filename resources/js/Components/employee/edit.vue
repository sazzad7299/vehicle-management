<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit employee /</span>
            <router-link :to="{ name: 'employee.index' }">
                employee List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Edit employee</h5>
                    <div class="card-body">
                        <form @submit.prevent="updateEmployee" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="employee.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                        autocomplete="off" v-model="employee.phone">
                                    <span v-if="this.allErrors.has('phone')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Email<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Email" name="email"
                                        autocomplete="off" v-model="employee.email">
                                    <span v-if="this.allErrors.has('email')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Address<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Address" name="address"
                                        autocomplete="off" v-model="employee.street_address">
                                    <span v-if="this.allErrors.has('street_address')"
                                        class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('street_address')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Salary<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="salary" name="salary"
                                        autocomplete="off" v-model="employee.salary">
                                    <span v-if="this.allErrors.has('salary')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('salary')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Joining<span
                                            class="text-danger">*</span> </label>
                                    <input type="date" class="form-control" placeholder="salary" name="salary"
                                        autocomplete="off" v-model="employee.joining_date">
                                    <span v-if="this.allErrors.has('joining_date')"
                                        class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('joining_date')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Designation<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Designation" name="post"
                                        autocomplete="off" v-model="employee.place">
                                    <span v-if="this.allErrors.has('place')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('place')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Country
                                        <span class="text-danger">*</span>
                                    </label>
                                    <v-select :options="countries" :label="'name'" name="country"
                                        :placeholder="'Select Country'" :reduce="country => country.id"
                                        :loading="Loader.country" v-model="employee.country_id"
                                        @update:modelValue="this.allErrors.clear(`country_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('country_id')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('country_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Division<span
                                            class="text-danger">*</span> </label>
                                    <v-select :options="divisions" :label="'name'" name="division_id"
                                        :placeholder="'Select Division'" :reduce="division => division.id"
                                        :loading="Loader.division" v-model="employee.division_id"
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
                                    <v-select :options="districts" :label="'name'" name="district_id"
                                        :placeholder="'Select District'" :reduce="district => district.id"
                                        :loading="Loader.district" v-model="employee.district_id"
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
                                    <v-select :options="upazilas" :label="'name'" name="upazilas_id"
                                        :placeholder="'Select Upzila'" :reduce="upzila => upzila.id"
                                        :loading="Loader.upzila" v-model="employee.upazilas_id"
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
                                    <v-select :options="unions" :label="'name'" name="union_id"
                                        :placeholder="'Select Union'" :reduce="union => union.id" :loading="Loader.union"
                                        v-model="employee.union_id" @update:modelValue="this.allErrors.clear('union_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('union_id')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('union_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Zip Code<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Zip Code" name="zip_code"
                                        autocomplete="off" v-model="employee.zip_code">
                                    <span v-if="this.allErrors.has('zip_code')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('zip_code')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">NID/PASSPORT/DRIVING<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="NID/PASSPORT/DRIVING" name="nid"
                                        autocomplete="off" v-model="employee.nid">
                                    <span v-if="this.allErrors.has('nid')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('nid')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Image<span
                                            class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="image"
                                        @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('image')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('image')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                        <input class="form-check-input switch-lg" type="checkbox" v-model="employee.status">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="employee_image ? employee_image : '/images/blank.jpg'"
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
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Edit employee",
    data() {
        return {
            allErrors: new Errors(),
            employee: {},
            employee_image: '',
            countries: [],
            divisions: [],
            districts: [],
            upazilas: [],
            unions: [],
            roles: [],
            Loader: {
                country: false,
                division: false,
                district: false,
                upzila: false,
                union: false,
                role: false,
            },
        }
    },
    watch: {
        'employee.country_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.employee.division_id = '';
                this.employee.district_id = '';
                this.employee.upazilas_id = '';
                this.employee.union_id = '';
                return;
            }
            this.getDivisionList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.employee.division_id = '';
                this.employee.district_id = '';
                this.employee.upazilas_id = '';
                this.employee.union_id = '';
            }
        },
        'employee.division_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.employee.district_id = '';
                this.employee.upazilas_id = '';
                this.employee.union_id = '';
                return;
            }

            this.getDistrictList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.employee.district_id = '';
                this.employee.upazilas_id = '';
                this.employee.union_id = '';
            }
        },
        'employee.district_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.employee.upazilas_id = '';
                return;
            }
            this.getUpzilaList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.employee.upazilas_id = '';
                this.employee.union_id = '';
            }
        },
        'employee.upazilas_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.employee.union_id = '';
                return;
            }
            this.getUnionList();
            if (newVal !== oldVal && oldVal !== undefined) {
                this.employee.union_id = '';
            }
        },
    },
    methods: {
        getemployee() {
            axios.get('employee/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.employee = response.data.result;
                    if (this.employee.image)
                        this.employee_image = '/' + this.employee.image;
                        this.employee.image = null;
                    if (this.employee.status == 1)
                    this.employee.status = true
                    else this.employee.status=false
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        updateEmployee() {
            this.loader(true);
            axios.put('employee/' + this.employee.id, {
                ...this.employee
            })
            .then(response => {
                    this.loader(false);
                    this.$router.push({name: 'employee.index'});
                    handleSuccessResponse.call(this, response);
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
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
            axios.get('country-wise-division/' + this.employee.country_id)
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
            axios.get('division-wise-district/' + this.employee.division_id)
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
            axios.get('district-wise-upzila/' + this.employee.district_id)
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
            axios.get('upzila-wise-union/' + this.employee.upazilas_id)
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
                this.employee.image = event.target.result;
                this.employee_image = this.employee.image;

            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {

    },
    created() {
        this.getemployee();
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

.form-check-input {
    width: 60px !important;
    height: 30px !important;
}
</style>
