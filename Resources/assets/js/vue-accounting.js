/**
 * Accounting 
 */
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.baseURL = document.head.querySelector('meta[name="base-url"]').content;

window.axios.defaults.headers.common = {
 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
 'Accept' : 'application/json'
};

//window.axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';


import { createApp } from 'vue';

import AccountingIndex from './components/accounting/Index.vue';

import router from './router/accounting';

createApp(AccountingIndex).use(router).mount('#accounting');
