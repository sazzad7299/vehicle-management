import {ref, reactive} from 'vue'
import {useRouter} from 'vue-router';
import {userStore} from "../stores/user";

export default function useAuth() {
    const processing = ref(false)
    const validationErrors = ref({})
    const router = useRouter()
    const auth = userStore();
    const loginForm = reactive({
        email: '',
        password: '',
        remember: false
    })
    const forgotForm = reactive({
        email: '',
    })
    const registerForm = reactive({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms_and_condition: false
    })


    const submitRegister = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}
        console.log(registerForm);
        axios.post('/register', registerForm)
            .then(async response => {
                if (response.data.status === 201) {
                    toastr.success(response.data.message)
                    
                    await loginUser(response.data.result)
                    await router.push({name: 'registersubscribe'});
                }
            })
            .catch(error => {
                if (error.response.status !== 422) {
                    toastr.error(error.response.data.message)
                }
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }


    const submitLogin = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}

        axios.post('/login', loginForm)
            .then(async response => {
                await loginUser(response.data.result)
                toastr.success(response.data.message)
            })
            .catch(error => {
                toastr.error(error.response.data.message)
                console.log(error)
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }

    const loginUser = async (data) => {

        auth.setUser(data);
        localStorage.setItem('pharmacy', data.token);
        await router.push({name: 'dashboard'});
    }

    const logout = () => {
        if (processing.value) return;
        processing.value = true;

        axios.post('/logout')
            .then(response => {
                router.push({name: 'login'});
                auth.setUser(null);
                localStorage.removeItem('pharmacy');
                toastr.success(response.data.message);
            })
            .catch(error => {
                console.log(error)
            })
            .finally(() => {
                processing.value = false;
            });
    };
   const submitForgotPassword = async () => {
        if (processing.value) return

        processing.value = true
        validationErrors.value = {}
        console.log(registerForm);
        axios.post('/forgot-password', forgotForm)
            .then(async response => {
                if (response.data.status === 200) {
                    toastr.success(response.data.message)
                    await router.push({name: 'login'});
                }
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }

    return {
        loginForm,
        forgotForm,
        registerForm,
        validationErrors,
        processing,
        submitLogin,
        submitRegister,
        logout,
        submitForgotPassword,
    }
}
