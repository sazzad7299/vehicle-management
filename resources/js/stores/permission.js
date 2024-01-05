import { defineStore } from 'pinia'
export const permissionStore = defineStore('permission', {
    state: () => {
        return {
            permissions: [],
        }
    },
    actions:{
        setPermissions(data){
            this.permissions = data
        }
    },
    getters: {
        getPermissions: (state) => {
            return state.permissions;
        }
    },
});
