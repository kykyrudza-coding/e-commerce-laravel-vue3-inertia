import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

const csrfClient = axios.create({
    baseURL: import.meta.env.VITE_API_ORIGIN || '',
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: 'application/json',
    },
});

export const csrf = () => csrfClient.get('/sanctum/csrf-cookie');

api.interceptors.response.use(
    (response) => response,
    (error) => {
        const status = error.response?.status;

        if (status === 401) {
            window.dispatchEvent(new CustomEvent('auth:unauthenticated'));
        }

        return Promise.reject(error);
    },
);

export const get = (url, config = {}) => api.get(url, config);
export const post = (url, data = {}, config = {}) => api.post(url, data, config);
export const put = (url, data = {}, config = {}) => api.put(url, data, config);
export const patch = (url, data = {}, config = {}) => api.patch(url, data, config);
export const destroy = (url, config = {}) => api.delete(url, config);

export default api;
