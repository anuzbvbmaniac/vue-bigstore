import Vue from 'vue'
import VueRouter from "vue-router"
require('./bootstrap');
Vue.use(VueRouter)

/**
 * Importing all Vue Components
 */
import App from './views/App'
import Home from './views/Home'
import Login from './views/Login'
import Register from './views/Register'
import SingleProduct from './views/SingleProduct'
import Checkout from './views/Checkout'
import Confirmation from './views/Confirmation'
import UserBoard from './views/UserBoard'
import Admin from './views/Admin'

/**
 * On some routes, we defined meta, which contains variables we would like to check
 * when we access the route. In our case, we are checking if the route requires authentication
 * and if it is restricted to administrators or regular users only.
 * @type {VueRouter}
 */
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/products/:id',
            name: 'single-products',
            component: SingleProduct
        },
        {
            path: '/confirmation',
            name: 'confirmation',
            component: Confirmation
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
            props: (route) => ({ pid: route.query.pid })
        },
        {
            path: '/dashboard',
            name: 'userboard',
            component: UserBoard,
            meta: {
                requiresAuth: true,
                isUser: true
            }
        },
        {
            path: '/admin/:page',
            name: 'admin-pages',
            component: Admin,
            meta: {
                requiresAuth: true,
                isAdmin: true
            }
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
            meta: {
                requiresAuth: true,
                isAdmin: true
            }
        },
    ]
})

/**
 * We set up the beforeEach middleware on the router that checks each route before going to it.
 * The method takes these variables:
 * --  to – the route you want to move to.
 * --  from – the current route you are moving away from.
 * --  next – the method that finally moves to a defined route.
 *           When called without a route passed, it continues the navigation.
 *           If given a route, it goes to that route.
 * We use beforeEach to check the routes that require authentication before you can access them.
 * For those routes, we check if the user is authenticated. If the user isn’t, we send them to
 * the login page. If the user is authenticated, we check if the route is restricted to
 * admin users or regular users. We redirect each user to the right place based on which
 * access level they have...
 */
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if(localStorage.getItem('bigStore.jwt') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('bigStore.user'))
            if(to.matched.some(record => record.meta.isAdmin)) {
                if(user.isAdmin === 1) {
                    next()
                } else {
                    next({ name: 'userboard' })
                }
            } else if(to.matched.some(record => record.meta.isUser)) {
                if(user.isAdmin === 0) {
                    next()
                } else {
                    next({ name: 'admin' })
                }
            }
        next()
        }
    } else {
        next()
    }
})

// Vue Application Instanciation.
const app = new Vue({
    el: '#app',
    components: { App },
    router,
})

