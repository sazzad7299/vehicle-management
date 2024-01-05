<template>
    <div >
        <!-- Use v-if and v-else to conditionally render the template -->
        <template v-if="$route.name === 'sale.create' || $route.name === 'purchase.create'">
            <Preloader />
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </template>
        <template v-else>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <Sidebar />
                <div class="layout-page">
                    <Navbar />
                    <div class="content-wrapper">
                        <Preloader />
                        <transition name="fade">
                            <router-view></router-view>
                        </transition>
                        <Bottom />
                    </div>
                </div>
            </div>
        </div>
         <div class="layout-overlay layout-menu-toggle"></div>
        </template>
    </div>
</template>
  
<script>
import { defineComponent } from 'vue';
import Bottom from "./partials/bottom.vue";
import Sidebar from "./partials/sidebar.vue";
import Navbar from "./partials/navbar.vue";
import Preloader from "./partials/preloader.vue";

export default defineComponent({
    name: "app",
    components: { Navbar, Sidebar, Preloader, Bottom },
});
</script>
  
<style scoped>
.fade-enter-active {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.fade-leave-active {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.fade-enter,
.fade-leave-active.show {
    opacity: 1;
}
</style>
  