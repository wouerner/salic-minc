import Vue from 'vue'
import Router from 'vue-router'
import Visualizar from './Visualizar'
import Proponente from '../Agente/Proponente'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Visualizar',
      component: Visualizar
    },
    {
        path: '/proponente/id',
        name: 'Proponente',
        component: Proponente
    }
  ]
})
