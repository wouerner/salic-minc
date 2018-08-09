import axios from 'axios';

export default class API {
    constructor(path) {
        this.path = path;
    }

    get(queryParams = '') {
        return axios.get(`${this.path}${queryParams}`);
    }

    post(data) {
        return axios.post(this.path, data);
    }

    put(bodyFormData, id) {
        return axios.post(`${this.path}/${id}`, bodyFormData);
    }

    delete(id) {
        return axios.delete(`${this.path}/${id}`);
    }
}
