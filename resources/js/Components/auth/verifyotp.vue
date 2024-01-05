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
                        <h4 class="mb-2">OTP Verification</h4>
                        <p class="mb-4">To reset you account,verify your 6 digit otp here</p>
                        
                        <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" @submit.prevent="submitForgotPassword">
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" class="form-control" id="otp" name="email-username"
                                       placeholder="-  -  -  -  -  -" autofocus=""
                                       v-model="verify.otp"/>
                                <span v-if="this.allErrors.has('otp')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('otp')">
                                    </span>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" >Send
                                </button>
                            </div>
                            <input type="hidden"/>
                        </form>

                        <p class="text-center">
                            <span>Have a account ? </span>
                            <router-link :to="{name: 'login'}">
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
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Create Customer",
    data() {
        return {
            allErrors: new Errors(),
            verify: {
                email: '',
                otp:null,
            },
            email:null
        }
    },
    mounted() {
        
        const token = this.$route.query.token;
        const email = this.$route.query.user_email;
        this.email =email;
        console.log(token);
        console.log(email);
    }

}


</script>
<style scoped>

</style>
