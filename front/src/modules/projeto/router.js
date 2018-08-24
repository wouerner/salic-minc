import Index from './Index';
import IncentivoTemplate from './incentivo/Index';
import PlanilhaPropostaOriginal from './incentivo/components/PlanilhaPropostaOriginal';
import PlanilhaPropostaAutorizada from './incentivo/components/PlanilhaPropostaAutorizada';
import PlanilhaPropostaAdequada from './incentivo/components/PlanilhaPropostaAdequada';
import PlanilhaHomologada from './incentivo/components/PlanilhaHomologada';
import PlanilhaReadequada from './incentivo/components/PlanilhaReadequada';
import RelacaoDePagamentos from './incentivo/components/RelacaoDePagamentos';
import Proposta from './incentivo/components/Proposta';

const DadosProjeto = () => import(/* webpackChunkName: "dados-projeto" */ './incentivo/components/DadosProjeto');
const Proponente = () => import(/* webpackChunkName: "proponente" */ './incentivo/components/proponente/Index');

const templateAjax = {
    template: '<div id="conteudo"></div>',
};

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
];
