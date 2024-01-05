<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    🚀
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">My Pharmacity</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Reset Password</h4>
                        <p class="mb-4"></p>

                        <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework"
                            @submit.prevent="submitresetPassword">
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="otp" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="otp" name="email-username"
                                    placeholder="******" autofocus="" v-model="form.password" />
                                <span v-if="this.allErrors.has('password')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('password')">
                                </span>
                            </div>
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="otp" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="otp" name="email-username"
                                    placeholder="******" autofocus="" v-model="form.password_confirmation" />
                                <span v-if="this.allErrors.has('password_confirmation')" class="error text-danger fw-semibold mt-3"
                                    v-text="this.allErrors.get('password_confirmation')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Send
                                </button>
                            </div>
                            <input type="hidden" />
                        </form>

                        <p class="text-center">
                            <span>Have a account ? </span>
                            <router-link :to="{ name: 'login' }">
                                <span>Login</span>
                            </router-link>
                        </p>

                        <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                <i class="tf-icons bx bxl-facebook"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                <i class="tf-icons bx bxl-google-plus"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                                <i class="tf-icons bx bxl-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
</template>
<script >
import _ from "lodash";
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Reset New Password",
    data() {
        return {
            allErrors: new Errors(),
            form: {
                token: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
        }
    },
    methods:{
        submitresetPassword(){
            this.loader(true);
            axios.post('reset-password', {
                ...this.form
            })
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                    this.$router.push({name: 'login'});
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                })
        }
    },
    mounted() {
        this.form.token = this.$route.query.token;
        this.form.email = this.$route.query.email;
    }

}


</script>
<style scoped></style>
