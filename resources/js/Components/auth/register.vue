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
                        <h4 class="mb-2">Welcome to Pharmacity! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <form class="row" @submit.prevent="submitRegister" >
                            <div class="mb-3 col-md-6 col-sm-12">
                                <label for="username" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus="" v-model="registerForm.name" />
                                <div v-for="message in validationErrors?.name" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-sm-12">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email"  v-model="registerForm.email"/>
                                <div v-for="message in validationErrors?.email" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-sm-12">
                                <label for="username" class="form-label">Your Store Name</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your store name" autofocus="" v-model="registerForm.pharmacy_name" />
                                <div v-for="message in validationErrors?.pharmacy_name" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-sm-12">
                                <label for="phone" class="form-label">Your Store Phone No.</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your store contact no"  v-model="registerForm.pharmacy_phone"/>
                                <div v-for="message in validationErrors?.pharmacy_phone" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-sm-12 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password" v-model="registerForm.password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div v-for="message in validationErrors?.password" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-sm-12 form-password-toggle">
                                <label class="form-label" for="password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                           name="password_confirmation"
                                           autocomplete="off" v-model="registerForm.password_confirmation">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div v-for="message in validationErrors?.password_confirmation" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>

                            <div class="mb-3 col-md-6 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms_and_conditions"  v-model="registerForm.terms_and_conditions"/>
                                    <label class="form-check-label">
                                        I agree to <strong class="terms text-info" @click="openModel">Privacy policy &amp; Terms</strong>
                                    </label>
                                </div>
                                <div v-for="message in validationErrors?.terms_and_conditions" class="error fw-semibold text-danger text-bold mt-2">
                                    {{ message }}
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit" :disabled="processing">Sign up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <router-link :to="{name:'login'}">
                                <span> Sign in instead</span>
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
                <Terms  v-if="showModal" @close="closeModel" @accept="accept"/>
                <!-- /Register -->
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import useAuth from '../../composables/auth';
import Terms from './terms.vue';
const { registerForm, validationErrors, processing, submitRegister} = useAuth();
let showModal = ref(false);

    const openModel = () => {
        showModal.value = true;
    };

    const closeModel = () => {
        showModal.value = false;
    };
    const accept = ()=>{
        registerForm.terms_and_conditions =true;
        closeModel();
    }
</script>
<style scoped>
    .authentication-inner{
        max-width: 600px!important;
    }
    .terms{
        cursor: pointer;
    }
</style>
