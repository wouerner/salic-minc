import Vue from 'vue';
import Router from 'vue-router';
import ListBar from './components/ListBar';
import CreateBar from './components/CreateBar';

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
    {
        path: '/create',
        name: 'CreateBar',
        component: CreateBar,
        meta: {
            title: 'Criar Bar',
        },
    },
];

export default new Router({ routes });
