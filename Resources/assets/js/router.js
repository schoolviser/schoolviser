import { createRouter, createWebHistory } from "vue-router";

import accountingRouter from "../../Modules/Accounting/Resources/assets/js/router";

import Home from "./components/ExampleComponent.vue";
import Settings from "./components/ExampleComponent.vue";
import About from "./components/settings/terms/TermIndex.vue";

const mainRoutes = [
    { path: "/", component: Home },
    { path: "/settings", component: Settings },
    { path: "/about", component: About },
];

const router = createRouter({
    history: createWebHistory("/app"), // 👈 Set base to `/app`
    routes: [...mainRoutes, ...accountingRouter.options.routes],
});

export default router;
