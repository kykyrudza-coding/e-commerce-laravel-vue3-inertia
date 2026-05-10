import { defineStore } from 'pinia';
import api, { clearAuthToken, setAuthToken } from '@/shared/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
        errors: {},
    }),
    actions: {
        async fetchUser() {
            try {
                const response = await api.get('/user');
                this.user = response.data.data;
            } catch {
                this.user = null;
            }
        },
        async login(credentials) {
            this.loading = true;
            this.errors = {};

            try {
                const response = await api.post('/login', credentials);
                setAuthToken(response.data.token);
                this.user = response.data.data;
                return response;
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async register(payload) {
            this.loading = true;
            this.errors = {};

            try {
                const response = await api.post('/register', payload);
                setAuthToken(response.data.token);
                this.user = response.data.data;
                return response;
            } catch (error) {
                this.errors = error.response?.data?.errors || {};
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async logout() {
            await api.post('/logout');
            clearAuthToken();
            this.user = null;
        },
    },
});
