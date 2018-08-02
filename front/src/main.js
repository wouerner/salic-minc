// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
// Vue.config.productionTip = false
// import 'es6-promise/auto';
import Vue from 'vue';
import App from './App';
// import Vuetify from 'vuetify'

import {
    store,
    router,
} from './config';


// asset imports
// import VueMaterial from 'vue-material'
// import 'vue-material/dist/vue-material.min.css'
// import './assets/scss/material-dashboard.scss'

// import 'vuetify/dist/vuetify.min.css'

// Vue.use(Vuetify)

Vue.config.productionTip = false;

// window.onload = () => {
/* eslint-disable-next-line */
const main = new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>',
});
// };
