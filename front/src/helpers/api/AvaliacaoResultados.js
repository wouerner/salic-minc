import * as api from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

const path = '/navegacao/menu-principal';

export const dadosMenu = () => api.getRequest(path);

export const criarRegistro = params => api.postRequest(path, buildData(params));

export const atualizarRegistro = params => api.putRequest(path, buildData(params), params.Codigo);

export const removerRegistro = params => api.deleteRequest(path, params.Codigo);

export const parecerConsolidacao = params => api.getRequest(`/avaliacao-resultados/emissao-parecer-rest/idPronac/${params}`);

export const criarParecer = (params) => {
    const parametro = params.idPronac;
    delete params.idPronac;
    const data = params;

    return api.postRequest(`/avaliacao-resultados/emissao-parecer-rest/idPronac/${parametro}`, buildData(data));
};

export const getTeste = params => api.postRequest('/realizarprestacaodecontas/carregar-destinatarios/', buildData(params));

export const getTipoAvaliacao = params => api.getRequest(`/avaliacao-resultados/tipo-avaliacao-rest/idPronac/${params}`);

export const obterDadosTabelaTecnico = (params) => {
    const data = params;
    return api.getRequest(`/avaliacao-resultados/fluxo-projeto?estadoid=${data.estadoid}&idAgente=${data.idAgente}`);
};

export const obterHistoricoEncaminhamento = params => api.getRequest(`/avaliacao-resultados/historico/idPronac/${params}`);

export const planilha = params => api.getRequest(`/prestacao-contas/realizar-prestacao-contas/planilha-analise-filtros/idPronac/${params}`);

export const projetoAnalise = params => api.getRequest(`/avaliacao-resultados/projeto/idPronac/${params}`);

export const consolidacaoAnalise = params => api.getRequest(`/prestacao-contas/visualizar-projeto/dados-projeto?idPronac=${params}`);

export const finalizarParecer = (params) => {
    // const parametro = params.idPronac;
    // delete params.idPronac;
    const data = params;

    return api.postRequest('/avaliacao-resultados/estado', buildData(data));
};

export const obterDestinatarios = () => api.getRequest('/avaliacao-resultados/tecnicos');

export const encaminharParaTecnico = params => api.postRequest('/avaliacao-resultados/estado/', buildData(params));

export const obterDadosItemComprovacao = params => api.getRequest(`/avaliacao-resultados/avaliacao-comprovante/${params}`);

export const criarParecerLaudoFinal = (params) => {
    console.log(params);
    // const parametro = params.idPronac;
    // delete params.idPronac;
    // const data = params;

    // return api.postRequest(`/avaliacao-resultados/emissao-parecer-rest/idPronac/${parametro}`, buildData(data));
};

export const finalizarParecerLaudoFinal = (params) => {
    console.log(params);
    // const parametro = params.idPronac;
    // delete params.idPronac;
    // const data = params;

    // return api.postRequest('/avaliacao-resultados/estado', buildData(data));
};

export const obterProjetosParaDistribuir = () => api.getRequest('/prestacao-contas/prestacao-contas/obter-analise-financeira-virtual');

export const criarDiligencia = params => api.postRequest('/diligencia/diligencia', buildData(params));

export const obterProjetosParaAssinatura = () => api.getRequest('/avaliacao-resultados/projeto-assinatura');

