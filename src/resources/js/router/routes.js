export const routes = [
    {
        path: '/',
        name: 'Home',
        component:() => import('../pages/Home.vue'),
        meta: {
            link: '/',
            requiredAuth: true,
        }
    },
    {
        path: '/login',
        name: 'Login',
        component:() => import('../pages/Login.vue'),
        meta: {
            authenticated: true
        }
    },
    {
        path: '/register',
        name: 'Register',
        component:() => import('../pages/Register.vue'),
        meta: {
            authenticated: true
        }
    }
]
