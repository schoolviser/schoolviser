import { createRouter, createWebHistory } from 'vue-router';

import Dashboard from '../components/Dashboard.vue';


const routes = [
 { path : '/master', component : Dashboard },
 { path : '/master/hello', component : Dashboard }
];

const router = createRouter({
 history : createWebHistory(),
 routes
});

export default router;
