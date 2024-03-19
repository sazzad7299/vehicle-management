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
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">IT SOFTRAIN</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">My Viehicle Management!</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" @submit.prevent="submitForgotPassword">
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email-username"
                                       placeholder="Enter your email get Reset link" autofocus=""
                                       v-model="forgotForm.email"/>
                                <div v-for="message in validationErrors?.email" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" :disabled="processing">Send
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
<script setup>
import useAuth from '../../composables/auth';


const {forgotForm, validationErrors, processing, submitForgotPassword} = useAuth()
</script>
<style scoped>

</style>
