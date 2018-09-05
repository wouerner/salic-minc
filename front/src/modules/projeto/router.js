import Vue from 'vue';
import Router from 'vue-router';

import Index from './index/Index';
import Visualizar from './visualizar/Index';
import DadosProjeto from './visualizar/DadosProjeto';
import PlanilhaPropostaOriginal from './visualizar/incentivo/components/PlanilhaPropostaOriginal';
import PlanilhaPropostaAutorizada from './visualizar/incentivo/components/PlanilhaPropostaAutorizada';
import PlanilhaPropostaAdequada from './visualizar/incentivo/components/PlanilhaPropostaAdequada';
import PlanilhaHomologada from './visualizar/incentivo/components/PlanilhaHomologada';
import PlanilhaReadequada from './visualizar/incentivo/components/PlanilhaReadequada';
import RelacaoDePagamentos from './visualizar/incentivo/components/RelacaoDePagamentos';
import Proponente from './components/proponente/Index';
import Proposta from './visualizar/incentivo/components/Proposta';

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
            title: 'Lista de projetos',
        },
    },
    {
        path: '/:idPronac',
        component: Visualizar,
        children: [
            {
                path: '',
                name: 'dadosprojeto',
                component: DadosProjeto,
                meta: {
                    title: 'Dados do Projeto',
                },
            },
            {
                path: 'proponente',
                name: 'proponente',
                component: Proponente,
                meta: {
                    title: 'Proponente',
                },
            },
            {
                path: 'planilha-proposta',
                name: 'planilhaproposta',
                component: PlanilhaPropostaOriginal,
                meta: {
                    title: 'Planilha de Solicita&ccedil;&atilde;o da Proposta Original',
                },
            },
            {
                path: 'planilha-autorizada',
                name: 'planilhaautorizada',
                component: PlanilhaPropostaAutorizada,
                meta: {
                    title: 'Planilha Autorizada para Captar',
                },
            },
            {
                path: 'planilha-adequada',
                name: 'planilhaadequada',
                component: PlanilhaPropostaAdequada,
                meta: {
                    title: 'Planilha Adequada &agrave; realidade de execu&ccedil;&atilde;o pelo proponente',
                },
            },
            {
                path: 'planilha-homologada',
                name: 'planilhahomologada',
                component: PlanilhaHomologada,
                meta: {
                    title: 'Planilha Homologada para execu&ccedil;&atilde;o',
                },
            },
            {
                path: 'planilha-aprovada',
                name: 'planilhaaprovada',
                component: PlanilhaHomologada,
                meta: {
                    title: 'Planilha Autorizada para Captar',
                },
            },
            {
                path: 'planilha-readequada',
                name: 'planilhareadequada',
                component: PlanilhaReadequada,
                meta: {
                    title: 'Planilha Readequada na execu&ccedil;&atilde;o',
                },
            },
            {
                path: 'relacao-de-pagamentos',
                name: 'relacaodepagamentos',
                component: RelacaoDePagamentos,
                meta: {
                    title: 'Rela&ccedil;&atilde;o de Pagamentos',
                },
            },
            {
                path: 'proposta',
                name: 'proposta',
                component: Proposta,
                meta: {
                    title: 'Proposta',
                },
            },
            {
                path: 'conteudo-dinamico',
                name: 'containerAjax',
                component: templateAjax,
            },
        ],
    },
];

export default new Router({ routes });
