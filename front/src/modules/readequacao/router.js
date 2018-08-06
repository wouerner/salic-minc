import Vue from 'vue';
import Router from 'vue-router';
import Index from './index/Index';
import SaldoAplicacaoTemplate from './SaldoAplicacao/Index';
import SaldoAplicacaoSaldoTemplate from './SaldoAplicacao/components/ReadequacaoSaldoAplicacaoSaldo';

Vue.use(Router);

const templateAjax = {
    template: '<div id="conteudo"></div>',
};

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
