import Vue from 'vue';
import Router from 'vue-router';
import ListBar from './components/ListBar';
import CreateBar from './components/CreateBar';
import UpdateBar from './components/UpdateBar';

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
    {
        path: '/atualizar/:id',
        name: 'UpdateBar',
        component: UpdateBar,
        meta: {
            title: 'Atualiza Bar',
        },
    },
];

export default new Router({ routes });
