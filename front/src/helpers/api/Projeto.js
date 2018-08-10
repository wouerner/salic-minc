import API from './base';

const api = () => new API();

export const buscaProjeto = (idPronac) => {
    const url = `/projeto/incentivo/obter-projeto-ajax/?idPronac=${idPronac}`;
    return api().get(url);
};

export const buscaProponente = (idPronac) => {
    const url = `/projeto/proponente-rest/?idPronac=${idPronac}`;
    return api().get(url);
};
