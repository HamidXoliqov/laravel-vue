import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home';
import * as auth from './services/auth_service'; 


Vue.use(Router);

const routers = [
    {
        path: '/home',
        component: Home,
        children: [
            {
                path: '/',
                name: 'dashboard',
                component: () => import('./views/Dashboard.vue'),
            },
            {
                path: '/home/categories',
                name: 'categories',
                component: () => import('./views/Categories.vue'),
                beforeEnter(to, from, next) {
                    if (auth.getUserRole() === 'admin') {
                        next()
                    } else {
                        next('/404')
                    }
                }
            },
            {
                path: '/home/products',
                name: 'products',
                component: () => import('./views/Products.vue'),
                beforeEnter(to, from, next) {
                    if (auth.getUserRole() === 'user') {
                        next()
                    } else {
                        next('/404')
                    }
                }
            },
        ],

        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login')
            } else {
                next()
            }
        }
    },
    
    {
        path: '/register',
        name: 'register',
        component: () => import('./views/authentication/Register.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./views/authentication/Login.vue'),
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next()
            } else {
                next('/home')
            }
        }
    },    
    {
        path: '/reset-password-request',
        name: 'reset-password-request',
        component: () => import('./views/authentication/ResetPasswordRequest.vue'),
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next()
            } else {
                next('/home')
            }
        }
    },
    {
        path: '/reset-password/:email',
        name: 'reset-password',
        component: () => import('./views/authentication/ResetPassword.vue'),
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next()
            } else {
                next('/home')
            }
        }
    },
    {
        path: '*',
        name: '404',
        component: () =>import('./views/404.vue'),
    }

];

const router = new Router({
    mode:'history',
    routes: routers,
    linkActiveClass: 'active'
}); 

export default router;

// 21 chi vedio darsga kelib qolindi
// https://www.youtube.com/watch?v=ZNehAfnXCcQ&list=PLR3-1he9bGShZT1FUMnVogdYNLbcK_Vp3&index=21

 
