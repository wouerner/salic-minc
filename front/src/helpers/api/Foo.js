import API from './base';

const api = () => new API();

export const obterDadosTabela = () => {
    const url = '/foo/foo-rest';
    return api().get(url);
};
