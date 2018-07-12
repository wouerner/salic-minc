import Vue from 'vue'
import Router from 'vue-router'
import Index from './index/Index'
import DadosProjeto from './incentivo/components/DadosProjeto'
import IncentivoTemplate from './incentivo/Index'
import PlanilhaProposta from './incentivo/components/PlanilhaProposta'
import PlanilhaAprovada from './incentivo/components/PlanilhaAprovada'
import PlanilhaCongelada from './incentivo/components/PlanilhaCongelada'
import RelacaoDePagamentos from './incentivo/components/RelacaoDePagamentos'
import Proponente from './incentivo/components/Proponente'

Vue.use(Router)

const templateAjax = {
    template: '<div id="conteudo"></div>'
}

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            title: 'Principal'
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
                    title: 'Dados do Projeto'
                }
            },
            {
                path: 'proponente',
                name: 'proponente',
                component: Proponente,
                meta: {
                    title: 'Proponente'
                }
            },
            {
                path: 'planilha-proposta',
                name: 'planilhaproposta',
                component: PlanilhaProposta,
                meta: {
                    title: 'Planilha Or&ccedil;ament&aacute;ria Proposta'
                }
            },
            {
                path: 'planilha-aprovada',
                name: 'planilhaaprovada',
                component: PlanilhaAprovada,
                meta: {
                    title: 'Planilha Or&ccedil;ament&aacute;ria Aprovada'
                }
            },
            {
                path: 'planilha-congelada',
                name: 'planilhacongelada',
                component: PlanilhaCongelada,
                meta: {
                    title: 'Planilha Proposta'
                }
            },
            {
                path: 'relacao-de-pagamentos',
                name: 'relacaodepagamentos',
                component: RelacaoDePagamentos,
                meta: {
                    title: 'Rela&ccedil;&atilde;o de Pagamentos'
                }
            },
            {
                path: 'conteudo-dinamico',
                name: 'container_ajax',
                component: templateAjax,
            }
        ]
    }
];

export default new Router({
    routes,
})

