require('./bootstrap');
window.Vue = require('vue').default;
import { createApp } from "vue";
const app = createApp({});
app.component('main-block', require('./components/MainBlock.vue').default);
app.mount('#app');
