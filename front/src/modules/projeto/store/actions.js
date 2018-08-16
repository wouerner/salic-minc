import * as projetoHelperAPI from '@/helpers/api/Projeto';
import { state } from './mutations';
import * as types from './types';

export const buscaProjeto = ({ commit }, idPronac) => {
    projetoHelperAPI.buscaProjeto(idPronac)
        .then((response) => {
            const data = response.data;
            const projeto = data.data;
            commit(types.SET_PROJETO, projeto);
        });
};

export const buscarValoresTransferidos = ({ commit }) => {
    const projeto = state.projeto;
    const idPronac = projeto.idPronac;
    projetoHelperAPI.buscarValoresTransferidos(idPronac)
        .then((response) => {
            const data = response.data;
            const valoresTransferidos = data.data;
            commit(types.SET_VALORES_TRANSFERIDOS, valoresTransferidos);
        });
};
