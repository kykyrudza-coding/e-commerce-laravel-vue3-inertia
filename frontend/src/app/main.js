import './styles/app.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import { route } from '@/shared/router';
import { bootstrapAuth, pageState } from '@/shared/lib/spa-compat';

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.config.globalProperties.route = route;
app.config.globalProperties.$page = pageState;
window.route = route;

app.mount('#app');
bootstrapAuth();
