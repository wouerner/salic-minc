import API from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

const api = () => new API('/foo/foo-rest');

export const obterDadosTabela = () => api().get();

export const criarRegistro = params => api().post(buildData(params));

export const atualizarRegistro = params => api().put(buildData(params), id);

export const removerRegistro = params => api().delete(params.Codigo);
