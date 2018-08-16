import * as api from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

export const buscaReadequacao = (params) => {
    const { idPronac, idTipoReadequacao } = params;
    const path = `/readequacao/readequacoes/obter-dados-readequacao/?idPronac=${idPronac}&idTipoReadequacao=${idTipoReadequacao}`;
    
    return api.getRequest(path);
};

export const updateReadequacao = (params) => {
    // TODO: refatorar controller que salva / mover para controller principal (tirar da saldo aplicacao)
    
    const path = `/readequacao/saldo-aplicacao/salvar-readequacao`;
    
    return api.putRequest(path, buildData(params), params.idReadequacao);
};

export const verificarDisponivelReadequacaoPlanilha = (idPronac) => {
    const path = `/readequacao/saldo-aplicacao/verificar-disponivel-para-edicao-readequacao-planilha/?idPronac=`;
    return api.getRequest(path, idPronac);
};
