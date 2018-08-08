import API from './base';

const api = () => new API('/projeto/incentivo/obter-projeto-ajax');

export const buscaProjeto = (idPronac) => {
    const queryParams = `?idPronac=${idPronac}`;
    return api().get(queryParams);
};
