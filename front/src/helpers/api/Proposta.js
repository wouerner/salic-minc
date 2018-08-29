import * as api from './base';

export const buscaLocalRealizacaoDeslocamento = (idPreProjeto) => {
    const path = `/proposta/visualizar/obter-local-realizacao-deslocamento/idPreProjeto/${idPreProjeto}`;
    return api.getRequest(path);
};

export const buscaFontesDeRecursos = (idPreProjeto) => {
    const path = `/proposta/visualizar/obter-fonte-de-recurso/idPreProjeto/${idPreProjeto}`;
    return api.getRequest(path);
};

export const buscaDocumentos = (idPreProjeto, idAgente) => {
    const path = `/proposta/visualizar/obter-documentos-anexados/idPreProjeto/${idPreProjeto}/idAgente/${idAgente}`;
    return api.getRequest(path);
};
