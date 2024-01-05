import './bootstrap';
import "vue-select/dist/vue-select.css";
import {Bootstrap5Pagination} from 'laravel-vue-pagination';
import {createApp} from 'vue'
import {createPinia} from 'pinia'
import router from './router/router';
import mixin from "./mixins/mixin";
import vSelect from "vue-select";
import moment from 'moment'
import PermissionsMixin from './mixins/permissionMixin';
const app = createApp({});
const pinia = createPinia();
app.use(router)
app.use(pinia);
app.mixin(mixin);
app.mixin(PermissionsMixin);
app.component("pagination", Bootstrap5Pagination);
app.component("v-select", vSelect);
app.config.globalProperties.$filters = {
    timeAgo(date) {
    return moment(date).fromNow()
    },
    customFormat(date) {
        return moment(date).format('D MMM YYYY');
      },
      MYFormat(date){
        return moment(date).format('MMMM YYYY');
      }
}
axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response.status === 403) {
      router.go(-1);
    }
    return Promise.reject(error);
  }
);
app.mount('#app');


