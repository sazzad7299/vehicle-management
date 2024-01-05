<template>
    <div class="card mb-4">
        <h5 class="card-header">Update Password</h5>
        <div class="card-body">
            <div class="mb-3">
                <div class="alert alert-danger">
                    <p class="mb-0">Ensure your account is using a long, random password to stay secure.</p>
                </div>
            </div>
            <form method="post" @submit.prevent="updatePassword"  @keydown="allErrors.clear($event.target.name)">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input class="form-control" type="password" id="current_password" name="current_password" autofocus v-model="changePassword.current_password"/>
                    <span v-if="this.allErrors.has('current_password')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('current_password')">
                    </span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input class="form-control" type="password" name="password" id="password" v-model="changePassword.password"/>
                    <span v-if="this.allErrors.has('password')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('password')">
                    </span>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" v-model="changePassword.password_confirmation"/>
                    <span v-if="this.allErrors.has('password_confirmation')"
                          class="error text-danger text-bold ms-2 mt-2"
                          v-text="this.allErrors.get('password_confirmation')">
                    </span>
                </div>
                <button type="submit" class="btn btn-warning me-2">Change Password</button>
            </form>
        </div>
    </div>

</template>
<script>
import {defineComponent} from 'vue'
import Errors from "../../../errors/errors";

export default defineComponent({
    name: "update-password-form",
    data() {
        return {
            allErrors: new Errors(),
            changePassword:{
                current_password:'',
                password:'',
                password_confirmation:'',
            }
        }
    },
    methods:{
        updatePassword(){
            this.loader(true);
            axios.patch('/profile/update-password', {
                ...this.changePassword
            })
                .then(response => {
                    if (response.status === 200) {
                        this.loader(false);
                        toastr.success(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status !== 422) {
                        toastr.error(error.message);
                    }
                    this.loader(false);
                    this.allErrors.record(error.response.data.errors);
                })
        }
    }
})
</script>
<style scoped>

</style>
