import Vue from 'vue';
import Vuex from 'vuex';
import Vuetify from 'vuetify';

import projeto from './modules/projeto/store';
import foo from './modules/foo/store';
import modal from '@/components/modal/store';

Vue.use(Vuex);
Vue.use(Vuetify);

const debug = process.env.NODE_ENV !== 'production' || process.env.NODE_ENV !== 'staging';

export default new Vuex.Store({
    modules: {
        projeto,
        foo,
        modal,
    },
    strict: debug,
});
