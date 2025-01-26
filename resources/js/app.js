require("./bootstrap");

import { createApp } from "vue";
import TermIndex from "./components/settings/terms/TermIndex.vue";

const app = createApp({});
app.component("term-index", TermIndex);
app.mount("#app");
