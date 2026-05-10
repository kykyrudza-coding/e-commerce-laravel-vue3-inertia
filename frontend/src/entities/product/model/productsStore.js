import { defineStore } from 'pinia';
import api from '@/shared/api';

export const useProductsStore = defineStore('products', {
    state: () => ({
        products: [],
        pagination: {},
        filters: {},
        loading: false,
    }),
    actions: {
        async fetchProducts(params = {}) {
            this.loading = true;
            try {
                const response = await api.get('/products', { params });
                this.products = response.data.data;
                this.pagination = response.data.meta || {};
                this.filters = response.data.filters || {};
                return response;
            } finally {
                this.loading = false;
            }
        },
    },
});
