import axios from 'axios';

const API_ENDPOINT = process.env.API_ENDPOINT;

let instance;

export default () => {
    if (instance) {
        return instance;
    }

    instance = axios.create({
        baseURL: API_ENDPOINT,
    });

    return instance;
};
