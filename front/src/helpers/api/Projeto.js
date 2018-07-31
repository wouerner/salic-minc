import API from './base';

const api = () => new API();

export const buscaProjeto = (idPronac) => {
    const url = `/projeto/incentivo/obter-projeto-ajax/?idPronac=${idPronac}`;
    return api().get(url);
};
