import axios from 'axios';

export const getRequest = (path, queryParams = '') => {
    return axios.get(`${path}${queryParams}`);
};

export const postRequest = (path, data) => {
    return axios.post(path, data);
};

export const putRequest = (path, bodyFormData, id) => {
    return axios.post(`${path}/${id}`, bodyFormData);
};

export const deleteRequest = (path, id) => {
    return axios.delete(`${path}/${id}`);
};
