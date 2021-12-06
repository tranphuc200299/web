import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
    {
        path: '/',
        name: 'App',
        component: Home
    },
    {
        path: '/:lang?/home',
        name: 'Home',
        component: Home
    },
    {
        path: "/:lang?/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ '../views/404.vue'),
    },
];
const router = createRouter({
    history: createWebHistory(process.env.VUE_APP_WEB_URL),
    routes
});

export default router
