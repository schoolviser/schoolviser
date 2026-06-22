require("./bootstrap");

// full-height + sidebar toggle in plain JS
document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const setFullHeight = () => {
        const elements = document.querySelectorAll('.js-fullheight');
        const height = window.innerHeight;
        elements.forEach(el => {
            el.style.height = height + 'px';
        });
    };

    setFullHeight();
    window.addEventListener('resize', setFullHeight);

    const sidebarToggle = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }
});


window.baseUrl = document
    .querySelector("meta[name='base-url']")
    .getAttribute("content");

//import { createApp } from "vue";
//import App from "./components/App.vue";
//import router from "./router";



//const app = createApp(App);
//app.use(router).mount("#app");
