require('./bootstrap');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = document.head.querySelector('meta[name="base-url"]').content;

import { createApp } from 'vue';

import App from './components/App.vue';
import router from './router';


createApp(App).use(router).mount('#app');