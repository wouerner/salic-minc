import Vue from 'vue'
import Router from 'vue-router'
import DadosProjeto from './incentivo/DadosProjeto'
import PlanilhaProposta from './incentivo/PlanilhaProposta'
import ContainerAjax from './incentivo/ContainerAjax'
import Proponente from './incentivo/Proponente'
import CarregarTemplateAjax from  '@/components/CarregarTemplateAjax';

Vue.use(Router)

const routes = [
    {
        path: '/incentivo/:idPronac',
        name: 'dadosprojeto',
        component: DadosProjeto,
        meta: {
            title: 'Dados do Projeto'
        },
    },
    {
        path: '/incentivo/:idPronac/proponente',
        name: 'proponente',
        component: Proponente,
        meta: {
            title: 'Proponente'
        }
    },
    {
        path: '/incentivo/:idPronac/planilha-proposta',
        name: 'planilhaProposta',
        component: PlanilhaProposta,
        meta: {
            title: 'Planilha Proposta'
        }
    } ,
    {
        path: '/incentivo/:idPronac/conteudo-dinamico',
        name: 'container_ajax',
        component: ContainerAjax,
        meta: {
            title: 'Dados do projeto'
        }
    }
];

export default new Router({
    routes,
})

