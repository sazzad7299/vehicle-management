<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add Plan /</span>
            <router-link :to="{ name: 'plan.index' }">
                Plan List
            </router-link>
        </h4>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add Plan</h5>
                    <div class="card-body">
                        <form @submit.prevent="createPlan" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        autocomplete="off" v-model="plan.name">
                                    <span v-if="this.allErrors.has('name')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Slug<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Slug" name="slug" disabled
                                        autocomplete="off" v-model="plan.slug">
                                    <span v-if="this.allErrors.has('slug')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('slug')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Monthly Price<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Price" name="monthly"
                                        autocomplete="off" v-model.number="plan.monthly">
                                    <span v-if="this.allErrors.has('monthly')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('monthly')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Annually Price<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Price" name="annually"
                                        autocomplete="off" v-model.number="plan.annually">
                                    <span v-if="this.allErrors.has('annually')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('annually')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="basic-default-name">Description<span
                                            class="text-danger">*</span> </label>
                                    <textarea class="form-control" placeholder="Description" name="description"
                                        autocomplete="off" v-model="plan.description"></textarea>
                                    <span v-if="this.allErrors.has('description')"
                                        class="error text-danger fw-semibold mt-3"
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


                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-4">
                                        <img class="img-fluid rounded-2 "
                                            :src="plan.image ? plan.image : '/images/blank.jpg'" alt="Card image cap">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="feature">Features</label>
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th>SL.</th>
                                                <th>Title</th>
                                                <th class="model">Model</th>
                                                <th>Quote</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in plan.features" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        v-model="plan.features[index].title">
                                                    <span v-if="this.allErrors.has('features.' + index + '.title')"
                                                        class="error text-danger fw-semibold mt-3"
                                                        v-text="this.allErrors.get('features.' + index + '.title')"></span>
                                                </td>
                                                <td>
                                                    <v-select :options="options" :label="'title'" :reduce="option => option"
                                                        name="model_type" :placeholder="'Select Model'"
                                                        v-model="plan.features[index].model"></v-select>
                                                        <span v-if="this.allErrors.has('features.' + index + '.model')"
                                                        class="error text-danger fw-semibold mt-3"
                                                        v-text="this.allErrors.get('features.' + index + '.model')"></span>

                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        v-model="plan.features[index].quote">
                                                        <span v-if="this.allErrors.has('features.' + index + '.quote')"
                                                        class="error text-danger fw-semibold mt-3"
                                                        v-text="this.allErrors.get('features.' + index + '.quote')"></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-around">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            @click="removeRow(index)">-</button>
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            @click="addRow">+</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
import { defineComponent } from 'vue'
import Errors from "../../errors/errors";

export default defineComponent({
    name: "create",
    data() {
        return {
            allErrors: new Errors(),
            plan: {
                name: '',
                slug: '',
                monthly: 0,
                annually: 0,
                image: '',
                description: '',
                features: [],
            },
            options:[]
        }
    },
    watch: {
        'plan.name': function (val) {
            this.plan.slug = this.slugify(val);
        }
    },
    methods: {
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.plan.image = event.target.result;
            };
            reader.readAsDataURL(file);
        },
        createPlan() {
            this.loader(true);
            axios.post('plan', {
                ...this.plan
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        toastr.success(response.data.message);
                        this.$router.push({ name: 'plan.index' });
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
        fetchModels() {
            axios.get("models")
            .then((response) => {
                this.options = response.data;
                console.log(this.options)
            })
            .catch((error) => {

            });
        },
        addRow() {
            this.plan.features.push({ title: '', model: '', quote: 0 }); // Add a new row with empty values
        },
        removeRow(index) {
            this.plan.features.splice(index, 1); // Remove the row at the specified index
        },
    },
    mounted() {
        // Add one row when the component is mounted
        this.addRow();
        this.fetchModels();
    },
})
</script>
<style scoped>
.model {
    width: 30%;
}
</style>
