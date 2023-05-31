import { createRouter, createWebHistory } from "vue-router";
import Dashboard from '../views/Dashboard.vue'
import Shorteners from '../views/Shorteners.vue'
import ShortenerView from '../views/ShortenerView.vue'
import DefaultLayout from '../components/DefaultLayout.vue'

const routes = [
    {
        path:'/',
        redirect: '/shorteners',
        component: DefaultLayout,
        children: [
            {path: '/dashboard', name: 'Dashboard', component: Dashboard},
            {path: '/shorteners', name: 'Shorteners', component: Shorteners},
            {path: '/shortener/create', name: 'ShortenerCreate', component: ShortenerView},
            {path: '/shortener/:id', name: 'ShortenerView', component: ShortenerView},
        ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router