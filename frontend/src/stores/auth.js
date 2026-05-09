import { defineStore } from 'pinia';
import api, { csrf } from '@/services/api';

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
                await csrf();
                const response = await api.post('/login', credentials);
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
                await csrf();
                const response = await api.post('/register', payload);
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
            this.user = null;
        },
    },
});
