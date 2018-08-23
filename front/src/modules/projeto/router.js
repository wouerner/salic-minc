// import Vue from 'vue';
// import Router from 'vue-router';
import Index from './Index';
import IncentivoTemplate from './incentivo/Index';
import PlanilhaPropostaAdequada from './incentivo/components/PlanilhaPropostaAdequada';
import PlanilhaHomologada from './incentivo/components/PlanilhaHomologada';
import PlanilhaReadequada from './incentivo/components/PlanilhaReadequada';
import RelacaoDePagamentos from './incentivo/components/RelacaoDePagamentos';
// import Proponente from './incentivo/components/Proponente';

const DadosProjeto = () => {
    import(/* webpackChunkName: "dados-projeto" */ './incentivo/components/DadosProjeto');
};

const Proponente = () => {
    import(/* webpackChunkName: "proponente" */ './incentivo/components/Proponente');
};

const PlanilhaPropostaOriginal = () => {
    import(/* webpackChunkName: "planilha-proposta" */ './incentivo/components/PlanilhaPropostaOriginal');
};

const PlanilhaPropostaAutorizada = () => {
    import(/* webpackChunkName: "planilha-autorizada" */ './incentivo/components/PlanilhaPropostaAutorizada');
};

const templateAjax = {
    template: '<div id="conteudo"></div>',
};

// const routes = [
export default [
    {
        path: '/projeto',
        name: 'indexProjeto',
        component: Index,
        meta: {
            title: 'Principal',
        },
    },
    {
        path: '/projeto/incentivo/:idPronac',
        component: IncentivoTemplate,
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
                    title: 'Planilha Inicial da Proposta',
                },
            },
            {
                path: 'planilha-autorizada',
                name: 'planilhaautorizada',
                component: PlanilhaPropostaAutorizada,
                meta: {
                    title: 'Planilha Aprovada para Capta&ccedil;&atilde;o',
                },
            },
            {
                path: 'planilha-adequada',
                name: 'planilhaadequada',
                component: PlanilhaPropostaAdequada,
                meta: {
                    title: 'Planilha Adequada &agrave; Execu&ccedil;&atilde;o do Projeto',
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
                path: 'planilha-readequada',
                name: 'planilhareadequada',
                component: PlanilhaReadequada,
                meta: {
                    title: 'Planilha Readequada pelo Proponente',
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
                path: 'conteudo-dinamico',
                name: 'container_ajax',
                component: templateAjax,
            },
        ],
    },
];

// export default new Router({ routes });
