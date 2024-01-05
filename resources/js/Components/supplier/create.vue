<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add Supplier /</span>
            <router-link :to="{ name: 'supplier.index' }">
                Supplier List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add Supplier</h5>
                    <div class="card-body">
                        <form @submit.prevent="storeSupplier" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="supplier.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                        autocomplete="off" v-model="supplier.phone">
                                    <span v-if="this.allErrors.has('phone')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Email<span
                                            class="text-danger">*</span> </label>
                                    <input type="email" class="form-control" placeholder="Email" name="email"
                                        autocomplete="off" v-model="supplier.email">
                                    <span v-if="this.allErrors.has('email')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Company Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Company Name" name="company"
                                        autocomplete="off" v-model="supplier.company">
                                    <span v-if="this.allErrors.has('company')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('company')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Company Phone<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Contact no" name="company_phone"
                                        autocomplete="off" v-model="supplier.company_phone">
                                    <span v-if="this.allErrors.has('company_phone')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('company_phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Address<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Address" name="address"
                                        autocomplete="off" v-model="supplier.address">
                                    <span v-if="this.allErrors.has('address')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('address')">
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
                                        <input class="form-check-input switch-lg" type="checkbox" v-model="supplier.status">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="supplier.image ? supplier.image : '/images/blank.jpg'"
                                            alt="Card image cap">
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
import { handleErrorResponse } from '../../errors/errorHandler.js';
export default {
    name: "Create supplier",
    data() {
        return {
            allErrors: new Errors(),
            supplier: {
                name: '',
                phone: '',
                email: '',
                address: '',
                company:'',
                company_phone:'',
                description:'',
                image: '',
                status: true,
            },
        }
    },

    methods: {
        storeSupplier() {
            this.loader(true);
            axios.post('supplier', {
                ...this.supplier
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({ name: 'supplier.index' });
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
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.supplier.image = event.target.result;
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
                    this.$router.push({name: 'supplier.index'});
                   
                });
        }
    },
    created(){
        this.fetchCreateData('App\\Models\\Supplier');
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
