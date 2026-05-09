import api from '@/services/api';

export function useCart() {
    const addToCart = async (productId, onSuccess) => {
        const response = await api.post('/cart/items', {
            product_id: productId,
            quantity: 1,
        });

        onSuccess?.(response);
        return response;
    };

    const removeFromCart = async (cartItemId, onSuccess) => {
        const response = await api.delete(`/cart/items/${cartItemId}`);

        onSuccess?.(response);
        return response;
    };

    return { addToCart, removeFromCart };
}
