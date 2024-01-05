import {permissionStore} from "../stores/permission";
export default {
    methods: {
      hasPermission(permissionKey) {
        const permission = permissionStore();
        return permission.getPermissions.includes(permissionKey);
      },
    },
  };
