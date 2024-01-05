<template>
    <div class="card mb-4">
        <h5 class="card-header">Profile Information</h5>
        <div class="card-body">
            <div class="mb-3">
                <div class="alert alert-dark">
                    <p class="mb-0">You can update your information here.</p>
                </div>
            </div>
            <form @submit.prevent="updateProfileInformation"  @keydown="allErrors.clear($event.target.name)">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" id="name" name="name" autofocus v-model="user.name"/>
                    <span v-if="this.allErrors.has('name')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('name')">
                    </span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" type="text" name="email" id="email" v-model="user.email"/>
                    <span v-if="this.allErrors.has('email')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('email')">
                    </span>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input class="form-control" type="text" name="phone" id="phone" v-model="user.phone"/>
                    <span v-if="this.allErrors.has('phone')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('phone')">
                    </span>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import {defineComponent} from 'vue'
import {userStore} from "../../../stores/user";
import Errors from "../../../errors/errors";

export default defineComponent({
    name: "update-profile-information-form",
    data() {
        return {
            allErrors: new Errors(),
            user:null,
        }
    },
    methods: {
        updateProfileInformation() {
            this.loader(true);
            axios.patch('/profile/update', {
                ...this.user
            })
                .then((response) => {
                    if (response.status === 200) {
                        this.loader(false);
                        // const auth = userStore();
                        // auth.setUser(response.data.result);
                        localStorage.setItem('user', JSON.stringify(response.data.result));
                        toastr.success(response.data.message);

                    }
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                    this.loader();
                })
        }
        
    },
    created() {
        const userInfo = userStore();
        this.user = userInfo.user;
    }
})
</script>
<style scoped>

</style>
