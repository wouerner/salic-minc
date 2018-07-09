// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
// Vue.config.productionTip = false
import Vue from 'vue';
import App from './App';
import router from './router'
// import { store, router } from './config';

Vue.config.productionTip = false;

/* eslint-disable no-new */


window.onload = function () {
    var main = new Vue({
        el: '#app',
        components: { App },
        template: '<App/>',
        created:  function () {
            console.log(this);
        }
    });
}