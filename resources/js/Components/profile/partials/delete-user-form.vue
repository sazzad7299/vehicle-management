<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "delete-user-form"
})
</script>

<template>
    <div class="card mb-4">
        <h5 class="card-header">Delete Account</h5>
        <div class="card-body">
            <div class="mb-3 col-12 mb-0">
                <div class="alert alert-warning">
                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your
                        account?</h6>
                    <p class="mb-0">Once you delete your account, there is no going back. Please be
                        certain.</p>
                </div>
            </div>
            <form id="formAccountDeactivation" onsubmit="return false">
                <button type="submit" class="btn btn-danger deactivate-account" disabled>Deactivate Account</button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
