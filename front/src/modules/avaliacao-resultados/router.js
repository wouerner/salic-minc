import Vue from 'vue';
import Router from 'vue-router';
import ComponenteEncaminhar from './components/ComponenteEncaminhar';
import EmitirParecer from './components/EmitirParecer';

Vue.use(Router);

const routes = [
    {
        path: '/componente-encaminhar',
        name: 'ListBar',
        component: ComponenteEncaminhar,
        meta: {
            title: 'Principal',
        },
    },
    {
        path: '/emitir-parecer/:id',
        name: 'EmitirEditar',
        component: EmitirParecer,
        meta: {
            title: 'Principal',
        },
    },
    {
        path: '/emitir-parecer',
        name: 'Emitir',
        component: EmitirParecer,
        meta: {
            title: 'Principal',
        },
    },
];

export default new Router({ routes });
