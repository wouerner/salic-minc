import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import projetoRoutes from '@/modules/projeto/router'

Vue.use(Router)

const baseRoutes = [
  {
    path: '/',
    name: 'HelloWorld',
    component: HelloWorld
  }
];

const routes = baseRoutes.concat(projetoRoutes);
export default new Router({
  routes,
})


