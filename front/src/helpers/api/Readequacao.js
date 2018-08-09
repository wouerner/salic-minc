import API from './base';

const api = () => new API('http://localhost');

export const buscaReadequacao = (params) => {
    const { idPronac, idTipoReadequacao } = params;
    const url = `/readequacao/readequacoes/obter-dados-readequacao/?idPronac=${idPronac}&idTipoReadequacao=${idTipoReadequacao}`;
    
    return api().get(url);
};

export const updateReadequacao = (params) => {
    const {} = params;
    // TODO: refatorar controller que salva / mover para controller principal (tirar da saldo aplicacao)
    const url = `/readequacao/saldo-aplicacao/salvar-dados-readequacao`;
    const id = 1;
    const paramsTeste = {};
    return api().put(url, id, paramsTeste);
};
