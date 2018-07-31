import instance from './instance';

const defaultConfig = () => ({
    // eslint-disable-next-line
    // headers: Object.assign({}, { 'Cookie': 'PHPSESSID=f35d28dcf98f13fded03d151ae088664' }),
});

export default class API {
    constructor(config = {}) {
        this.path = config.path;

        this.axios = instance();
    }

    // eslint-disable-next-line
    get(url, resource = '', config = {}) {
        return this.axios.get(url, Object.assign({}, defaultConfig(), config));
    }
}
