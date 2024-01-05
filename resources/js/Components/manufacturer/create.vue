<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ formTitle }} / </span>
            <router-link :to="{ name: 'manufacturer.index' }">Driver List</router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">{{ formTitle }}</h5>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="manufacturer.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                        autocomplete="off" v-model="manufacturer.phone">
                                    <span v-if="this.allErrors.has('phone')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Email<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Email" name="email"
                                        autocomplete="off" v-model="manufacturer.email">
                                    <span v-if="this.allErrors.has('email')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Address<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Address" name="address"
                                        autocomplete="off" v-model="manufacturer.address">
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
                                        <input class="form-check-input switch-lg" type="checkbox"
                                            v-model="manufacturer.status">
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
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';
export default {
    name: "Create/Update Driver",
    props: {
        isEdit: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            allErrors: new Errors(),
            formTitle: this.isEdit ? "Update Driver" : "Add Driver",
            manufacturer: {
                name: '',
                phone: '',
                email: '',
                address: ''
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
            axios.post('manufacturer', {
                ...this.manufacturer
            })
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.$router.push({ name: 'manufacturer.index' });
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
                this.manufacturer.logo = event.target.result;
                this.manufacturer_logo = this.manufacturer.logo;
            };
            reader.readAsDataURL(file);
        },

        updateManufacturer() {
            let id=this.$route.params.id;
            this.loader(true);
            axios
                .put(`manufacturer/${id}`, { ...this.manufacturer })
                .then((response) => {
                    handleSuccessResponse.call(this, response);
                    this.$router.push({ name: 'manufacturer.index' });
                })
                .catch((error) => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                });
        },


        fetchManufacturerData() {
            let id=this.$route.params.id;
            axios
            .get(`manufacturer/${id}`)
            .then((response) => {
            this.manufacturer = response.data.result;
            if (this.manufacturer.logo)
                {
                    this.manufacturer_logo = '/' + this.manufacturer.logo;
                    this.manufacturer.logo = null;
                }
            if (this.manufacturer.status === 1) {
                this.manufacturer.status = true;
            } else {
                this.manufacturer.status = false;
            }
            })
            .catch((error) => {
                handleErrorResponse.call(this, error);
                this.$router.push({ name: 'manufacturer.index' });
            });
        },
    },
    created() {
        if (this.isEdit) {
        this.fetchManufacturerData();
        }
    }
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
