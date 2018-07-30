import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
import RotasProjeto from '@/modules/projeto/router';
import RotasFoo from '@/modules/foo/router';

Vue.use(Router);

const baseRoutes = [
    {
        path: '/',
        name: 'HelloWorld',
        component: HelloWorld,
    },
];

let routes = [];
routes = routes.concat(baseRoutes);
routes = routes.concat(RotasProjeto);
routes = routes.concat(RotasFoo);

export default new Router({
    routes,
});
