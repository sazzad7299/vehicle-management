<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ formTitle }} / </span>
            <router-link :to="{ name: 'medicine.index' }">Vehicle List</router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">{{ formTitle }}</h5>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Model<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="barcode"
                                        autocomplete="off" v-model="medicine.barcode">
                                    <span v-if="this.allErrors.has('barcode')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('barcode')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="medicine.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">License Plate <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Generic Name" name="generic"
                                        autocomplete="off" v-model="medicine.generic">
                                    <span v-if="this.allErrors.has('generic')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('generic')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Department
                                        <span class="text-danger">*</span>
                                    </label>
                                    <v-select :options="categories"
                                              :label="'name'"
                                              name="category_id"
                                              :placeholder="'Select Department'"
                                              :reduce="category => category.id"
                                              :loading="Loader.category"
                                              v-model="medicine.category_id"
                                              @update:modelValue="this.allErrors.clear(`category_id`)">
                                    </v-select>
                                    <span v-if="this.allErrors.has('category_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('category_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Vehicle Type<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="types"
                                              :label="'name'"
                                              name="type_id"
                                              :placeholder="'Select Type'"
                                              :reduce="type => type.id"
                                              :loading="Loader.type"
                                              v-model="medicine.type_id"
                                              @update:modelValue="this.allErrors.clear('type_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('type_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('type_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">RTA Circle Office<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="units"
                                              :label="'name'"
                                              name="unit_id"
                                              :placeholder="'Select RTA'"
                                              :reduce="unit => unit.id"
                                              :loading="Loader.unit"
                                              v-model="medicine.unit_id"
                                              @update:modelValue="this.allErrors.clear('unit_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('unit_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('unit_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Ownership<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="leaves"
                                              :label="'leaf_type'"
                                              name="leaf_id"
                                              :placeholder="'Select Ownership'"
                                              :reduce="leaf => leaf.id"
                                              :loading="Loader.leaf"
                                              v-model="medicine.leaf_id"
                                              @update:modelValue="this.allErrors.clear('leaf_id')">
                                    </v-select>

                                    <span v-if="this.allErrors.has('leaf_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('leaf_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Driver<span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="manufacturers"
                                              :label="'name'"
                                              name="manufacturer_id"
                                              :placeholder="'Select Driver'"
                                              :reduce="manufacturer => manufacturer.id"
                                              :loading="Loader.manufacturer"
                                              v-model="medicine.manufacturer_id"
                                              @update:modelValue="this.allErrors.clear('manufacturer_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('manufacturer_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('manufacturer_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Expire Date<span
                                            class="text-danger">*</span> </label>
                                    <input type="date" class="form-control" placeholder="Name" name="description"
                                        autocomplete="off" v-model="medicine.description">
                                    <span v-if="this.allErrors.has('description')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('description')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Image<span
                                            class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="image"
                                        @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('image')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('image')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                        <input class="form-check-input switch-lg" type="checkbox"
                                            v-model="medicine.status">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="manufacturer_logo? manufacturer_logo : '/images/blank.jpg'"
                                            alt="Card image cap">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="d-grid gap-2 col-lg-4 mx-auto">
                                    <button class="btn btn-primary" type="submit">{{ formTitle }}</button>
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
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
    name: "Medicine",
    props: {
        isEdit: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            allErrors: new Errors(),
            formTitle: this.isEdit ? "Update Vehicle" : "Add Vehicle",
            medicine: {
                barcode:'',
                name:'',
                generic:'',
                category_id: '',
                type_id: '',
                unit_id: '',
                leaf_id: '',
                manufacturer_id: '',
                description: '',
                status:true,
            },
            categories: [],
            types: [],
            units: [],
            leaves: [],
            manufacturers: [],
            Loader: {
                category: false,
                type: false,
                unit: false,
                leaf: false,
                manufacturer: false,
            },
            manufacturer_logo:'',
        };
    },
    // Other component code
    methods: {
        handleSubmit() {
            if (this.isEdit) {
                this.updateManufacturer();
            } else {
                this.createManufacturer();
            }
        },

        createManufacturer() {
            this.loader(true);
            axios.post('medicine', {
                ...this.medicine
            })
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.$router.push({ name: 'medicine.index' });
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        updateManufacturer() {
            let id=this.$route.params.id;
            this.loader(true);
            axios
            .put(`medicine/${id}`, { ...this.medicine })
            .then((response) => {
                handleSuccessResponse.call(this, response);
                this.$router.push({ name: 'medicine.index' });
            })
            .catch((error) => {
                this.loader(false);
                handleErrorResponse.call(this, error);
            });
        },
        fetchMedicine() {
            let id=this.$route.params.id;
            axios
            .get(`medicine/${id}`)
            .then((response) => {
            this.medicine = response.data.result;
            if (this.medicine.image)
                {
                    this.manufacturer_logo = '/' + this.medicine.image;
                    this.medicine.image = null;
                }
            if (this.medicine.status === 1) {
                this.medicine.status = true;
            } else {
                this.medicine.status = false;
            }
            })
            .catch((error) => {

                handleErrorResponse.call(this, error);
                this.$router.push({ name: 'medicine.index' });
            });
        },
        getCategory() {
            this.Loader.category = true;
            axios.get('category',{
                params:{
                    paginate:false,
                }
            })
                .then(response => {
                    this.Loader.category = false;
                    this.categories = response.data.result;
                    this.getType();
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                });
        },
        getType() {
            this.Loader.type = true;
            axios.get('type' ,{
                params:{
                        paginate:false,
                    }
                })
                .then(response => {
                    setTimeout(() => {
                        this.Loader.type = false;
                    }, 500);
                    this.types = response.data.result;
                    this.getUnit();
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                })

        },
        getUnit() {
            this.Loader.unit = true;
            axios.get('unit' ,{
                params:{
                        paginate:false,
                    }
                })
                .then(response => {
                    setTimeout(() => {
                        this.Loader.unit = false;
                    }, 500);
                    this.units = response.data.result;
                    this.getLeaf()
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                })
        },
        getLeaf() {
            this.Loader.leaf = true;
            axios.get('leaf' ,{
                params:{
                        paginate:false,
                    }
                })
                .then(response => {
                    setTimeout(() => {
                        this.Loader.leaf = false;
                    }, 500);
                    this.leaves = response.data.result;
                    this.getManufacturer();
                })
                .catch(error => {
                    toastr.error("Failed to load")
                })
        },
        getManufacturer() {
            this.Loader.manufacturer = true;
            axios.get('manufacturer' ,{params:{paginate:false,}})
                .then(response => {
                    setTimeout(() => {
                        this.Loader.manufacturer = false;
                    }, 500);
                    this.manufacturers = response.data.result;
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                })
        },
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.medicine.image = event.target.result;
                this.manufacturer_logo = this.medicine.image;
            };
            reader.readAsDataURL(file);
        },
    },
    created() {
        if (this.isEdit) {
        this.fetchMedicine();
        }
    },
    mounted() {
        this.getCategory();
    },
};

</script>

<style scoped>
.image-container {
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}

.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

.img-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #ccc;
    border-radius: 50%;
}
</style>
