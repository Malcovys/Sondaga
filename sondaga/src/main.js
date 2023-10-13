import './assets/index.css'

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';
import App from './App.vue'
import router from './router';

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// le port doit être ecrit directement dans le code
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: 6001,
    forceTLS: false,
    enabledTransports: ['ws'],
    disebleStats: true,
});

const pinia = createPinia();
const app = createApp(App);

app.use(pinia)
app.use(router)
app.use(VueApexCharts)
app.mount('#app')
