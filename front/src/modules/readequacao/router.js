import Vue from 'vue';
import Router from 'vue-router';
import Index from './index/Index';
import SaldoAplicacaoTemplate from './SaldoAplicacao/Index';
import PainelReadequacoes from './components/PainelReadequacoes';

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
    {
        path: '/readequacoes/:idPronac',
        component: PainelReadequacoes,
        meta: {
            title: 'Painel de Readequações',
        },
    },
];

export default new Router({ routes });
