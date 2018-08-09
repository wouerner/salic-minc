import instance from './instance';

export default class API {
    constructor(path) {
        this.path = path;
        this.axios = instance();
    }

    get(id = '') {
        return this.axios.get(`${this.path}/${id}`);
    }

    post(data) {
        return this.axios.post(this.path, data);
    }

    put(bodyFormData, id) {
        return this.axios.post(`${this.path}/${id}`, bodyFormData);
    }

    delete(id) {
        return this.axios.delete(`${this.path}/${id}`);
    }
}
