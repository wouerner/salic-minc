import Vue from 'vue';
import Router from 'vue-router';
import ListBar from './components/ListBar';

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'ListBar',
        component: ListBar,
        meta: {
            title: 'Principal',
        },
    },
];

export default new Router({ routes });
