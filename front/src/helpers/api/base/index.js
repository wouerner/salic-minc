import instance from './instance';

export default class API {
    constructor(path) {
        this.path = path;
        this.axios = instance();
    }

    get(id = '') {
        return this.axios.get(`${this.path}/${id}`);
    }

    post(bodyFormData) {
        return this.axios.post(this.path, bodyFormData);
    }

    put(bodyFormData, id) {
        return this.axios.post(`${this.path}/${id}`, bodyFormData);
    }
}
