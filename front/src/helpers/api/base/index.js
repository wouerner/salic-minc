import instance from './instance';

export default class API {
    constructor(path) {
        this.path = path;
        this.axios = instance();
    }

    get(queryParams = '') {
        return this.axios.get(`${this.path}${queryParams}`);
    }

    post(bodyFormData) {
        return this.axios.post(this.path, bodyFormData);
    }

    put(bodyFormData, id) {
        return this.axios.post(`${this.path}/${id}`, bodyFormData);
    }

    delete(id) {
        return this.axios.delete(`${this.path}/${id}`);
    }
}
