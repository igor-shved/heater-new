import {createApp, provide, ref} from "vue";
import store from "./store";
import axios from "axios";

/*import router from "./router";*/

const app = createApp({});
/*heater.use(router).mount('#heater'); */
app.component('menu_block', require('./components/MenuBlock.vue').default);
app.component('heater_block', require('./components/HeaterBlock.vue').default);
app.component('modal_window', require('./components/ModalBlock.vue').default);
app.use(store, axios).mount('#app');
