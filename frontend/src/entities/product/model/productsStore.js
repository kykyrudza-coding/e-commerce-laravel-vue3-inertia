import { defineStore } from 'pinia';
import api, { apiData, apiMeta } from '@/shared/api';

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
                const meta = apiMeta(response);
                this.products = apiData(response, []);
                this.pagination = meta;
                this.filters = meta.filters || {};
                return response;
            } finally {
                this.loading = false;
            }
        },
    },
});
