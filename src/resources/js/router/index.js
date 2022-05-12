import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes';
import useAuth  from '../hooks/useAuth';

const { isAuth } = useAuth();
const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from) => {
    if (to.meta.requiredAuth && ! isAuth.value) {
        return '/login';
    }
    if (to.meta.authenticated && isAuth.value) {
        return  '/';
    }
});


export default router;
