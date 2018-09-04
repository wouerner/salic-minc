import Vue from 'vue';
import Vuex from 'vuex';

import modal from '@/components/modal/store';
import projeto from './modules/projeto/store';
import readequacao from './modules/readequacao/store';
import foo from './modules/foo/store';
import avaliacaoResultados from './modules/avaliacaoResultados/store';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production' || process.env.NODE_ENV !== 'staging';

export default new Vuex.Store({
    modules: {
        projeto,
        readequacao,
        foo,
        modal,
        avaliacaoResultados,
    },
    strict: debug,
});
