import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

const AUTH_TOKEN_KEY = 'auth_token';
const ENVELOPE_KEYS = ['success', 'message', 'data', 'errors', 'meta'];

const hasOwn = (object, key) => Object.prototype.hasOwnProperty.call(object, key);

const isAxiosResponse = (value) =>
    value && typeof value === 'object' && (hasOwn(value, 'status') || hasOwn(value, 'headers') || hasOwn(value, 'config'));

const isApiEnvelope = (value) =>
    value && typeof value === 'object' && ENVELOPE_KEYS.some((key) => hasOwn(value, key));

export const apiPayload = (responseOrPayload) => {
    if (isAxiosResponse(responseOrPayload)) {
        return responseOrPayload.data ?? {};
    }

    return responseOrPayload ?? {};
};

export const apiData = (responseOrPayload, fallback = null) => {
    const payload = apiPayload(responseOrPayload);

    if (isApiEnvelope(payload) || hasOwn(payload, 'data')) {
        return payload.data ?? fallback;
    }

    return fallback;
};

export const apiMeta = (responseOrPayload, fallback = {}) => {
    const payload = apiPayload(responseOrPayload);

    return payload.meta ?? payload.pagination ?? fallback;
};

export const apiErrors = (errorOrResponse, fallback = {}) => {
    const payload = apiPayload(errorOrResponse?.response ?? errorOrResponse);

    return payload.errors ?? fallback;
};

export const apiMessage = (responseOrPayload, fallback = '') => {
    const payload = apiPayload(responseOrPayload);

    return payload.message ?? fallback;
};

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
