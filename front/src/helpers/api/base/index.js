import instance from './instance';

export default class API {
    constructor(path) {
        this.path = path;
        this.axios = instance();
    }

    get(resource = '') {
        return this.axios.get(`${this.path}${resource}`);
    }

    post(bodyFormData, resource = '') {
        return this.axios.post(`${this.path}${resource}`, bodyFormData);
    }
}
