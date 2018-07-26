import Vue from 'vue';
import Router from 'vue-router';
// import Index from './Index';
import Bar from './components/Bar';

Vue.use(Router);

const routes = [
  {
    path: '/',
    name: 'index',
    component: Bar,
    meta: {
      title: 'Principal',
    },
  },
];

export default new Router({ routes });
