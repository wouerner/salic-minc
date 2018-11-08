import Vue from 'vue';
import Router from 'vue-router';
import Index from './index/Index';
import SaldoAplicacaoTemplate from './SaldoAplicacao/Index';

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            title: 'Principal',
        },
    },
    {
        path: '/saldo-aplicacao/:idPronac',
        component: SaldoAplicacaoTemplate,
        meta: {
            title: 'Saldo de aplicação',
        },
    },
];

export default new Router({ routes });
