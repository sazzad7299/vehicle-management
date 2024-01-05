<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
        <div class="row">
            <div class="col-md-6">
                <update-profile-information-form></update-profile-information-form>
            </div>
            <div class="col-md-6">
                <update-password-form></update-password-form>
            </div>
            <!-- <div class="col-md-12">
                <delete-user-form></delete-user-form>
            </div> -->
            <div class="col-md-12" v-if="hasPermission('pharmacy.edit')">
                <update-pharmacy-info></update-pharmacy-info>
            </div>
        </div>
    </div>
</template>
<script>
import {defineComponent} from 'vue'
import UpdateProfileInformationForm from "./partials/update-profile-information-form.vue";
import UpdatePasswordForm from "./partials/update-password-form.vue";
import UpdatePharmacyInfo from "./partials/update-pharmacy-info.vue";
import DeleteUserForm from "./partials/delete-user-form.vue";

export default defineComponent({
    name: "edit",
    components: {DeleteUserForm, UpdatePasswordForm, UpdateProfileInformationForm,UpdatePharmacyInfo}
})
</script>
<style scoped>

</style>
