<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add Customer /</span>
            <router-link :to="{ name: 'customer.index' }">
                Customer List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add Customer</h5>
                    <div class="card-body">
                        <form @submit.prevent="createCustomer" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="customer.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                        autocomplete="off" v-model="customer.phone">
                                    <span v-if="this.allErrors.has('phone')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Email<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Email" name="email"
                                        autocomplete="off" v-model="customer.email">
                                    <span v-if="this.allErrors.has('email')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Address<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Address" name="address"
                                        autocomplete="off" v-model="customer.address">
                                    <span v-if="this.allErrors.has('address')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('phone')">
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
                                        <input class="form-check-input switch-lg" type="checkbox" v-model="customer.status">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="customer.image ? customer.image : '/images/blank.jpg'"
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
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Create Customer",
    data() {
        return {
            allErrors: new Errors(),
            customer: {
                name: '',
                phone: '',
                email: '',
                address: '',
                image: '',
                status: true,
            },
        }
    },

    methods: {
        createCustomer() {
            this.loader(true);
            axios.post('customer', {
                ...this.customer
            })
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.customer.image = event.target.result;
            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {

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
