import Vue from 'vue'
import Router from 'vue-router'
import Index from './index/Index'
import DadosProjeto from './incentivo/components/DadosProjeto'
import IncentivoTemplate from './incentivo/Index'
import PlanilhaProposta from './incentivo/components/PlanilhaProposta'
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
                name: 'planilhaProposta',
                component: PlanilhaProposta,
                meta: {
                    title: 'Planilha Proposta'
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

