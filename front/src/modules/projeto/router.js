import Vue from 'vue';
import Router from 'vue-router';
import Index from './index/Index';
import DadosProjeto from './incentivo/components/DadosProjeto';
import IncentivoTemplate from './incentivo/Index';
import PlanilhaPropostaOriginal from './incentivo/components/PlanilhaPropostaOriginal';
import PlanilhaPropostaAutorizada from './incentivo/components/PlanilhaPropostaAutorizada';
import PlanilhaPropostaAdequada from './incentivo/components/PlanilhaPropostaAdequada';
import PlanilhaHomologada from './incentivo/components/PlanilhaHomologada';
import PlanilhaReadequada from './incentivo/components/PlanilhaReadequada';
import RelacaoDePagamentos from './incentivo/components/RelacaoDePagamentos';
import Proponente from './components/proponente/Index';
import Proposta from './incentivo/components/Proposta';
import ConvenioTemplate from './convenio/Index';
import DadosProjetoConvenio from './convenio/components/DadosProjeto';

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
        path: '/incentivo/:idPronac',
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
                name: 'container_ajax',
                component: templateAjax,
            },
        ],
    },
    {
        path: '/convenio/:idPronac',
        component: ConvenioTemplate,
        children: [
            {
                path: '',
                name: 'dadosprojetoConvenio',
                component: DadosProjetoConvenio,
                meta: {
                    title: 'Dados do Projeto',
                },
            },
            {
                path: 'proponente',
                name: 'proponenteConvenio',
                component: Proponente,
                meta: {
                    title: 'Proponente',
                },
            },
        ],
    },
];

export default new Router({ routes });
