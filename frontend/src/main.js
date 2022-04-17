import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./index.css";

const app = createApp(App);

app.config.globalProperties.auth = JSON.parse(localStorage.getItem("user"));
app.use(store);
app.use(router);
app.mount("#app");
