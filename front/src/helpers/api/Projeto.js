import API from './base';

const api = () => new API('/foo/foo-rest');

export const buscaProjeto = (idPronac) => {
    const url = `/projeto/incentivo/obter-projeto-ajax/?idPronac=${idPronac}`;
    return api().get(url);
};
