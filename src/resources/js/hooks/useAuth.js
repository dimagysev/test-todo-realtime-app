import { computed, reactive } from 'vue';

const state = reactive({
    token: localStorage.getItem('token') || null,
    loading: false
});

export default function useAuth () {

    const getToken = computed(() => state.token);
    const isAuth = computed(() => !! state.token);
    const isAuthLoading = computed(() => state.loading);

    const setToken = token => {
        state.token = token;
        localStorage.setItem('token', token);
    };
    const setAuthLoading = bool => state.loading = bool;

    async function register (credentials) {
        await beforeAuthSend();
        try {
            const response = await axios.post('/api/register', credentials);
            afterAuthSend(response);
            return true;
        } catch (e) {
            Object.values(e.response.data.errors).flat().forEach(item => {
                M.toast({ html: item });
            });
            setAuthLoading(false);
            return false;
        }
    }

    async function login (credentials) {
        await beforeAuthSend();
        try {
            const response = await axios.post('/api/login', credentials);
            afterAuthSend(response);
            return true;
        } catch (e) {
            M.toast({ html:e.response.data.message });
            setAuthLoading(false);
            return false;
        }
    }

    async function logout () {
        setAuthLoading(true);
        await axios.post('/api/logout');
        localStorage.removeItem('token');
        state.token = null;
        setAuthLoading(false);
    }

    async function beforeAuthSend() {
        setAuthLoading(true);
        await axios.get('/sanctum/csrf-cookie');
    }

    function afterAuthSend(response) {
        setToken(response.data.data.token);
        setAuthHeader();
        setAuthLoading(false);
    }

    function setAuthHeader () {
        axios.defaults.headers.common.Authorization = `Bearer ${ getToken.value }`;
    }

    return  {
        isAuth,
        isAuthLoading,
        setAuthHeader,
        login,
        register,
        logout,
        getToken
    }
}



