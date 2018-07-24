import Vue from 'vue';
import Vuex from 'vuex';

import projeto from './modules/projeto/store';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production' || process.env.NODE_ENV !== 'staging';

export default new Vuex.Store({
  modules: {
    projeto,
  },
  strict: debug,
});
