// import Vue from 'vue';
// import Router from 'vue-router';
// import Index from './Index';
import Bar from './components/Bar';

// Vue.use(Router);

export default [
    {
        path: '/foo',
        name: 'fooIndex',
        component: Bar,
        meta: {
            title: 'Principal',
        },
    },
];

// export default new Router({ routes });
