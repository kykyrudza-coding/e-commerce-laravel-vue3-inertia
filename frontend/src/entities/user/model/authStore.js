import { defineStore } from 'pinia';
import api, { apiData, apiErrors, clearAuthToken, setAuthToken } from '@/shared/api';

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
                this.user = apiData(response);
            } catch {
                this.user = null;
            }
        },
        async login(credentials) {
            this.loading = true;
            this.errors = {};

            try {
                const response = await api.post('/login', credentials);
                const session = apiData(response, {});
                setAuthToken(session.token);
                this.user = session.user;
                return response;
            } catch (error) {
                this.errors = apiErrors(error);
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
                const session = apiData(response, {});
                setAuthToken(session.token);
                this.user = session.user;
                return response;
            } catch (error) {
                this.errors = apiErrors(error);
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
