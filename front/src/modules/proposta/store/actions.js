import * as propostaHelperAPI from '@/helpers/api/Proposta';

import * as types from './types';

export const buscaLocalRealizacaoDeslocamento = ({ commit }, idPreProjeto) => {
    propostaHelperAPI.buscaLocalRealizacaoDeslocamento(idPreProjeto)
        .then((response) => {
            const data = response.data;
            const localRealizacaoDeslocamento = data.data;
            commit(types.SET_LOCAL_REALIZACAO_DESLOCAMENTO, localRealizacaoDeslocamento);
        });
};

export const buscaFontesDeRecursos = ({ commit }, idPreProjeto) => {
    propostaHelperAPI.buscaFontesDeRecursos(idPreProjeto)
        .then((response) => {
            const data = response.data;
            const fontesDeRecursos = data.data;
            commit(types.SET_FONTES_DE_RECURSOS, fontesDeRecursos);
        });
};

export const buscaDocumentos = ({ commit }, idPreProjeto, idAgente) => {
    propostaHelperAPI.buscaDocumentos(idPreProjeto, idAgente)
        .then((response) => {
            const data = response.data;
            const documentos = data.data;
            commit(types.SET_DOCUMENTOS, documentos);
        });
};
