<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-md-center">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="card bg-primary ">
                                    <h5 class="card-header fw-bold text-center text-white text-uppercase">
                                        {{ roleInfo.name }}
                                        <span>
                                            <img src="https://img.icons8.com/fluent/28/000000/microsoft-admin.png" alt="" />
                                        </span>
                                    </h5>
                                </div>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th style="width:250px ;"><input type="checkbox"
                                                    class="form-check-input p-2 mx-2" @click="accessAll"
                                                    v-if="hasPermission('role.create')" />Module Permission
                                            </th>
                                            <th>Feature Permission
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(permission_data, index) in permissionList" :key="index">
                                            <td v-if="permission_data.description === 'FEATURE'">
                                                <input type="checkbox"
                                                    :checked="permittedPermission.includes(permission_data.id)"
                                                    @click="accessFeaturePermit(permission_data.id, $event)"
                                                    class="form-check-input" :data-permission-id="permission_data.id"
                                                    :id="'checkbox_' + permission_data.id"
                                                    v-if="hasPermission('role.create')" /> <label
                                                    :for="'checkbox_' + permission_data.id">{{ permission_data.display_name
                                                    }}</label>
                                            </td>
                                            <template v-if="hasPermission('role.create')">
                                                <td v-if="permission_data.description === 'FEATURE'" class="permissions">
                                                    <div class="" v-for="(feature_data, index) in permissionList"
                                                        :key="index">
                                                        <div class="custom-checkbox"
                                                            v-if="permission_data.display_name === feature_data.description && feature_data.type !== null">
                                                            <input type="checkbox"
                                                                :checked="permittedPermission.includes(feature_data.id)"
                                                                @click="accessPermit(feature_data.id)"
                                                                class="form-check-input"
                                                                :data-permission-id="feature_data.id"
                                                                :id="'checkbox_' + feature_data.id" />
                                                            <label for="permission2" class="form-check-label px-3">{{
                                                                feature_data.display_name }}</label><br>
                                                        </div>

                                                    </div>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td v-if="permission_data.description === 'FEATURE'" class="permissions">
                                                    <div class="" v-for="(feature_data, index) in permissionList"
                                                        :key="index">
                                                        <div class="custom-checkbox"
                                                            v-if="permission_data.display_name === feature_data.description && feature_data.type !== null">
                                                            <label v-if="permittedPermission.includes(feature_data.id)"
                                                                for="permission2" class="form-check-label px-3">{{
                                                                    feature_data.display_name }}</label><br>
                                                        </div>
                                                    </div>
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue'
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default defineComponent({
    display_name: "assign-permission",
    data() {
        return {
            roleInfo: {},
            permissionList: [],
            permittedPermission: [],
            isPharmacy: null
        }
    },
    methods: {
        getRolePermissions() {
            axios
                .get(`/rbac/roles/${this.$route.params.id}/permissions`)
                .then((response) => {
                    let data = response.data.result;
                    this.roleInfo = data.role;
                    this.permissionList = data.permissions;
                    this.permittedPermission = data.permitted_permissions;
                    toastr.success(response.data.message);
                })
                .catch((error) => {
                    alert(error.response.data.message);
                    toastr.error("Application error", "Success");
                });
        },
        accessPermit(permissionId) {
            let role_id = this.roleInfo.id;
            let permissionForm = {
                role_id: role_id,
                permission_id: permissionId,
            };

            axios
                .post('/rbac/assign-role-permission', permissionForm)
                .then(response => {
                    this.loader(false);
                    handleSuccessResponse.call(this, response);
                })
                .catch(error => {
                    this.loader(false);
                    this.playSound();
                    handleErrorResponse.call(this, error);
                })
        },
        accessAll() {
            const allCheckboxes = document.querySelectorAll('.form-check-input');
            const selectedPermissions = [];
            const deselectedPermissions = [];

            const isChecked = allCheckboxes[0].checked;

            allCheckboxes.forEach((checkbox, index) => {
                if (index !== 0) {
                    checkbox.checked = isChecked;
                    const permissionId = checkbox.dataset.permissionId; // Adjust this based on your data attribute

                    if (isChecked) {
                        selectedPermissions.push(permissionId);
                    } else {
                        deselectedPermissions.push(permissionId);
                    }
                }
            });

            if (selectedPermissions.length > 0 || deselectedPermissions.length > 0) {
                let role_id = this.roleInfo.id;
                let permissionForm = {
                    role_id: role_id,
                    selectedIds: selectedPermissions,
                    deselectedIds: deselectedPermissions,
                };

                console.log(permissionForm);
                axios
                    .post('/rbac/assign-role-permissions', permissionForm) // Change the endpoint to handle an array of permissions
                    .then(response => {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                    })
                    .catch(error => {
                        this.loader(false);
                        this.playSound();
                        handleErrorResponse.call(this, error);
                    })
            }
        },
        accessFeaturePermit(permissionId) {
            const isChecked = event.target.checked;
            const selectedPermissions = [];
            const deselectedPermissions = [];
            this.accessPermit(permissionId);
            const featurePermission = this.permissionList.find(permission => permission.id === permissionId);
            if (featurePermission) {
                const featureItems = this.permissionList.filter(item =>
                    item.description === featurePermission.display_name &&
                    item.type !== null
                );
                console.log(featureItems);
                if (isChecked === true) {
                    featureItems.forEach(item => {
                        this.permittedPermission.push(item.id);
                        selectedPermissions.push(item.id);
                    });
                } else {
                    const featureItemsIds = featureItems.map(item => item.id);
                    const removedItemIds = this.permittedPermission.filter(id => featureItemsIds.includes(id));
                    deselectedPermissions.push(...removedItemIds);
                    this.permittedPermission = this.permittedPermission.filter(id => !featureItemsIds.includes(id));
                }
                if (selectedPermissions.length > 0 || deselectedPermissions.length > 0) {
                    let role_id = this.roleInfo.id;
                    let permissionForm = {
                        role_id: role_id,
                        selectedIds: selectedPermissions,
                        deselectedIds: deselectedPermissions,
                    };

                    console.log(permissionForm);
                    axios
                        .post('/rbac/assign-role-permissions', permissionForm) // Change the endpoint to handle an array of permissions
                        .then(response => {
                            this.loader(false);
                            handleSuccessResponse.call(this, response);

                        })
                        .catch(error => {
                            this.loader(false);
                            this.playSound();
                            handleErrorResponse.call(this, error);
                        })
                }
            }
        }

    },
    created() {
        this.getRolePermissions();
        this.isPharmacy = localStorage.getItem('PharmacyUser');
    }
})
</script>
<style scoped>
.permissions {
    display: flex !important;
    flex-direction: row;
    flex-wrap: wrap;
}</style>
