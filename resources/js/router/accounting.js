/**
 * Accounting Router
 */

import { createRouter, createWebHistory } from 'vue-router';


import Overview from '../components/accounting/Overview.vue';

import Expenses from '../components/accounting/expenses/Index.vue';


import Bills from '../components/accounting/bills/Index.vue';


const routes = [
 { path : '/accounting', name : 'accounting', component : Overview },
 { path : '/accounting/expenses', name : 'accounting.expenses', component : Expenses },
 { path : '/accounting/bills', name : 'accounting.bills', component : Bills },
];

const router = createRouter({
 history : createWebHistory(),
 routes
});

export default router;
