import API from '@/helpers/api/base/index';
 
let response;
let error;
 
const originalAPI = {
  get: API.prototype.get,
};
 
const getPromise = (currentResponse = response, currentError = error) => {
  const promise = {};
 
  promise.then = (callback) => {
    if (!currentResponse.data || currentResponse.data.errors) {
      currentError = currentResponse.data.errors;
      return getPromise(currentResponse, currentError);
    }
 
    if (currentResponse) {
      return getPromise(callback(currentResponse), currentError);
    }
 
    return getPromise(currentResponse, currentError);
  };
 
  promise.catch = (callback) => {
    if (currentError) {
      return getPromise(currentResponse, callback(currentError));
    }
 
    return getPromise(currentResponse, currentError);
  };
 
  response = null;
  error = null;
 
  return promise;
};
 
export const enable = () => {
  API.prototype.get = () => getPromise();
};
 
export const disable = () => {
  API.prototype.get = originalAPI.get;
};
 
export const setResponse = (data) => {
  if (data) {
    response = { data };
    return;
  }
 
  response = null;
};
 
export const setError = (data) => {
  error = data;
};
 
enable();
 
export default API;