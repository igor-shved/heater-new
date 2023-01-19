require('./bootstrap');
window.Vue = require('vue').default;
import { createApp } from "vue";
import router from "./router";
const app = createApp({});
app.component('main-block', require('./components/MainBlock.vue').default);
app.component('room-block', require('./components/RoomBlock.vue').default);
app.use(router).mount('#heater');
