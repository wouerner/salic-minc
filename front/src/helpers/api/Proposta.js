import * as api from './base';

export const buscaLocalRealizacaoDeslocamento = (idPreProjeto) => {
    const path = `/proposta/visualizar/obter-local-realizacao-deslocamento/idPreProjeto/${idPreProjeto}`;
    return api.getRequest(path);
};
