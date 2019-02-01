import * as prestacaoContasHelperAPI from '@/helpers/api/PrestacaoContas';
import * as types from './types';

export const buscarPagamentosConsolidados = ({ commit }, idPronac) => {
    prestacaoContasHelperAPI.buscarPagamentosConsolidados(idPronac)
        .then((response) => {
            const data = response.data.data.items;
            commit(types.SET_PAGAMENTOS_CONSOLIDADOS, data);
        });
};

export const buscarPagamentosUfMunicipio = ({ commit }, idPronac) => {
    prestacaoContasHelperAPI.buscarPagamentosUfMunicipio(idPronac)
        .then((response) => {
            const data = response.data.data.items;
            commit(types.SET_PAGAMENTOS_UF_MUNICIPIO, data);
        });
};
