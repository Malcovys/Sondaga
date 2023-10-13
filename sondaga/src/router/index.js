import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

import SingUp from '../views/SingUp.vue';
import LogIn from '../views/LogIn.vue';
import Home from '../views/Home.vue';
import Sondage from '../views/Sondage.vue';
import Vote from '../views/Vote.vue';

const routes = [
    {
        path:'/',
        name:'Home',
        component: Home,
        meta: { requiresAuth: true},
    },
    {
        path:'/sondage',
        name:'Sondage',
        component: Sondage,
        meta: { requiresAuth: true},
    },
    {
        path:'/vote',
        name:'vote',
        component: Vote,
        meta: { requiresAuth: true},
    },
    {
        path:'/login', 
        name:'LogIn',
        component: LogIn, 
        meta: { requiresAuth: false },
    },
    {
        path:'/singup', 
        name:'SingUp', 
        component: SingUp, 
        meta: { requiresAuth: false }
    },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const user = useAuthStore();

    if (to.meta.requiresAuth && !user.isAuthenticated) {
        next({ name: "LogIn" });
    }
    // } else if (!to.meta.requiresAuth && user.isAuthenticated) {
    //     next({ name: "Home" });
     else {
        next();
    }
});

export default router;