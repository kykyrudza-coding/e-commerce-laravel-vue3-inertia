import { defineStore } from 'pinia';
import api from '@/shared/api';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [],
        loading: false,
    }),
    actions: {
        async fetchCart() {
            this.loading = true;
            try {
                const response = await api.get('/cart');
                this.items = response.data.data;
            } finally {
                this.loading = false;
            }
        },
        async addItem(productId, quantity = 1) {
            const response = await api.post('/cart/items', { product_id: productId, quantity });
            await this.fetchCart();
            return response;
        },
        async updateItem(itemId, quantity) {
            const response = await api.patch(`/cart/items/${itemId}`, { quantity });
            await this.fetchCart();
            return response;
        },
        async removeItem(itemId) {
            await api.delete(`/cart/items/${itemId}`);
            this.items = this.items.filter((item) => item.id !== itemId);
        },
        async clear() {
            await api.delete('/cart');
            this.items = [];
        },
    },
});
