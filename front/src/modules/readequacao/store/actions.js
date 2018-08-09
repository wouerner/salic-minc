import * as readequacaoHelperAPI from '@/helpers/api/Readequacao';

import * as types from './types';

export const buscaReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacao(params)
        .then((response) => {
            const data = response.data;
            const readequacao = data.data;
            commit(types.SET_READEQUACAO, readequacao);
        });
};

export const updateReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacao(params)
        .then((response) => {
	    console.log('chegou na actions');
            //const data = response.data;
            //const readequacao = data.data;
            //commit(types.SET_READEQUACAO, readequacao);
        });    
};
