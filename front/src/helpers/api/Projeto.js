import API from './base';

export default class Projeto extends API {
    constructor(path) {
        // config.path = 'categories';
        const config = {};
        config.path = path;

        super(config);
    }

    buscaProjeto(idPronac) {
        const url = '/projeto/incentivo/obter-projeto-ajax/?idPronac=' +  idPronac;
        return this.get(url);
    }
}
