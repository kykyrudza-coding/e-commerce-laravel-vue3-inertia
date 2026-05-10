import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

const AUTH_TOKEN_KEY = 'auth_token';

export const getAuthToken = () => localStorage.getItem(AUTH_TOKEN_KEY);
export const setAuthToken = (token) => localStorage.setItem(AUTH_TOKEN_KEY, token);
export const clearAuthToken = () => localStorage.removeItem(AUTH_TOKEN_KEY);

api.interceptors.request.use((config) => {
    const token = getAuthToken();

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

api.interceptors.response.use(
    (response) => response,
    (error) => {
        const status = error.response?.status;

        if (status === 401) {
            clearAuthToken();
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
