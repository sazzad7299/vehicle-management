<template>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <a href="#" class="app-brand-link gap-2">
                <span
                  class="app-brand-text demo text-body fw-bolder text-uppercase"
                  >My Vehicle</span
                >
              </a>
            </div>
            <!-- /Logo -->

            <form
              class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework"
              @submit.prevent="submitLogin"
            >
              <div class="mb-3 fv-plugins-icon-container">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email-username"
                  placeholder="Enter your email or username"
                  autofocus=""
                  v-model="loginForm.email"
                />
                <div v-for="message in validationErrors?.email">
                  {{ message }}
                </div>
              </div>
              <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="javascript::void(0)">
                    <router-link :to="{ name: 'forgotPassword' }">
                      <small>Forgot Password?</small></router-link
                    >
                  </a>
                </div>
                <div class="input-group input-group-merge has-validation">
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    v-model="loginForm.password"
                    class="form-control"
                    name="password"
                    placeholder="············"
                    aria-describedby="password"
                  />
                  <span
                    class="input-group-text cursor-pointer"
                    @click="togglePasswordVisibility"
                  >
                    <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"></i
                  ></span>
                </div>
                <div v-for="message in validationErrors?.password">
                  {{ message }}
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember-me"
                    v-model="loginForm.remember"
                  />
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <button
                  class="btn btn-primary d-grid w-100"
                  type="submit"
                  :disabled="processing"
                >
                  Sign in
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import useAuth from "../../composables/auth";

const {
  loginForm,
  validationErrors,
  processing,
  submitLogin,
  showPassword,
  togglePasswordVisibility,
} = useAuth();
</script>
<style scoped>
</style>
