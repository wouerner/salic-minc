import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
import Pagina404 from '@/components/404';
import RotasFoo from '@/modules/foo/router';

Vue.use(Router);

const baseRoutes = [
    {
        path: '/',
        name: 'HelloWorld',
        component: HelloWorld,
    },
    {
        path: '*',
        component: Pagina404,
    },
];

let routes = [];
routes = routes.concat(RotasFoo);
routes = routes.concat(baseRoutes);

export default new Router({
    routes,
});
