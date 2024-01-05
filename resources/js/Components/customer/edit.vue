<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Customer /</span>
            <router-link :to="{ name: 'customer.index' }">
                Customer List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Edit Customer</h5>
                    <div class="card-body">
                        <form @submit.prevent="updateCustomer" @keydown="allErrors.clear($event.target.name)">
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
                                            class="text-danger">*</span> </label>
                                    <div class="form-check form-switch form-switch-lg mb-2 col-md-12">
                                        <input class="form-check-input" type="checkbox" v-model="customer.status"
                                            :checked="customer.status === 1">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview"
                                            :src="customer_image ? customer_image : '/images/blank.jpg'"
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
    name: "Edit Customer",
    data() {
        return {
            allErrors: new Errors(),
            customer: {},
            customer_image: ''
        }
    },
    methods: {
        getCustomer() {
            axios.get('customer/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.customer = response.data;
                    if (response.data.image)
                        this.customer_image = '/' + response.data.image;
                    this.customer.image = null;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        updateCustomer() {
            this.loader(true);
            axios.put('customer/' + this.customer.id, {
                ...this.customer
            })
                .then(response => {
                    if (response.status === 200) {

                        toastr.success(response.data.message);
                        this.$router.push({ name: 'customer.index' });
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
                this.customer.image = event.target.result;
                this.customer_image = this.customer.image;

            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {

    },
    created() {
        this.getCustomer();
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
