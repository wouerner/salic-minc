import * as rodapeHelperAPI from '@/helpers/api/Layout';
import * as desencapsularResponse from '@/helpers/actions/index';
import * as types from './types';

export const buscarVersao = ({ commit }) => {
    rodapeHelperAPI.buscarVersao()
        .then((response) => {
            const versao = desencapsularResponse.default(response);
            commit(types.SET_VERSAO, versao[0]);
        });
};
