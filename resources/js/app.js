import "./bootstrap";
import { createApp } from "vue";
import router from "./routes.js";
import store from "./store/index.js";
import vuetify from "./vuetify";
import MainComponent from "./pages/main.vue";

const app = createApp({});

app.component("main-component", MainComponent);
app.use(router);
app.use(store);
app.use(vuetify);
app.mount("#app");
