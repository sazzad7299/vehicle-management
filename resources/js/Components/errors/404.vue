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
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">My Vehicle</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">404! 👋</h4>
                        <p class="mb-4">Sorry We can not find any data related your Search Url. Please Enter a valid Url</p>

                        <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <router-link :to="{ name: 'dashboard' }" class="btn btn-sm btn-info"> Dashboard</router-link>
                        </div>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

</template>
<script setup>
</script>
<style></style>
