// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
// Vue.config.productionTip = false
import Vue from 'vue';
import Index from './Index';
import { store, router } from './config';

Vue.config.productionTip = false;

/* eslint-disable no-new */
window.onload = function () {
    var main = new Vue({
        el: '#app',
        router,
        store,
        components: { Index },
        template: '<Index/>',
        created:  function () {
        }
    });
}