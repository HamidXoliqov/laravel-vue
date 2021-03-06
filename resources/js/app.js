import Vue from 'vue';
import App from './App.vue';
import router from './router.js';
import store from './store';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

import BootstrapVue from 'bootstrap-vue';
import VueFlashes from '@smartweb/vue-flash-message';

Vue.use(BootstrapVue); 
Vue.use(VueFlashes);

console.log(router)


new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
    template: '<App />'
});
