import { router } from '@inertiajs/vue3';

/**
 * Cart composable — uses Inertia router so responses are always Inertia-compatible.
 * The backend must return back() or an Inertia::render(), NOT a plain JsonResponse.
 */
export function useCart() {
    /**
     * @param {number|string} productId
     * @param {Function} [onSuccess] — optional callback after Inertia finishes
     */
    const addToCart = (productId, onSuccess) => {
        router.post(
            route('products.add-to-cart', productId),
            {},
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => onSuccess?.(),
                onError: (errors) => console.error('addToCart error:', errors),
            },
        );
    };

    /**
     * @param {string} productSlug
     */
    const removeFromCart = (productSlug) => {
        router.post(
            route('products.delete-from-cart', { slug: productSlug }),
            {},
            { preserveScroll: true },
        );
    };

    return { addToCart, removeFromCart };
}
