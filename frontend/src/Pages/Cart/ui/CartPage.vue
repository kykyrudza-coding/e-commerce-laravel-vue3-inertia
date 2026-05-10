<template>
    <Head title="Кошик" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Кошик</span>
        </nav>

        <!-- Empty -->
        <div v-if="!state.products.length" class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-24 h-24 rounded-3xl bg-surface-100 flex items-center justify-center mb-6">
                <i class="ri-shopping-bag-3-line text-5xl text-surface-300"></i>
            </div>
            <h1 class="text-2xl font-bold text-surface-800 mb-2">Ваш кошик порожній</h1>
            <p class="text-surface-500 mb-8">Додайте товари з нашого каталогу</p>
            <RouterLink :to="route('products.index')" class="btn-primary btn-lg" id="cart-go-shop-btn">
                <i class="ri-store-3-line"></i>
                Перейти до каталогу
            </RouterLink>
        </div>

        <!-- Cart with items -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items list -->
            <div class="lg:col-span-2 space-y-4">
                <h1 class="page-title mb-6">Кошик</h1>

                <div
                    v-for="product in state.products"
                    :key="product.id"
                    class="card p-4 flex items-start gap-4 animate-fade-in"
                >
                    <!-- Image -->
                    <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-surface-100">
                        <img
                            v-if="product.main_image"
                            :src="imageUrl(domain, product.main_image.image_path)"
                            :alt="product.name"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                            <i class="ri-image-2-line text-2xl"></i>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h2 class="text-sm font-semibold text-surface-800 truncate mb-1">{{ product.name }}</h2>
                        <p class="text-xs text-surface-400 mb-2">{{ product.category?.name }}</p>
                        <p class="price">{{ formatPrice(product.price) }}</p>
                    </div>

                    <!-- Remove -->
                    <button
                        @click="removeItem(product)"
                        class="btn-icon text-red-400 hover:bg-red-50 hover:text-red-600 flex-shrink-0"
                        :aria-label="`Видалити ${product.name}`"
                    >
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>

            <!-- Order summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-20">
                    <h2 class="font-semibold text-surface-900 mb-5">Підсумок замовлення</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-surface-600">
                            <span>Товари ({{ state.products.length }})</span>
                            <span>{{ formatPrice(totals.subtotal) }}</span>
                        </div>
                        <div v-if="Number(totals.discount) > 0" class="flex justify-between text-emerald-600">
                            <span>Знижка</span>
                            <span>−{{ formatPrice(totals.discount) }}</span>
                        </div>
                        <div class="pt-3 border-t border-surface-100 flex justify-between font-bold text-base text-surface-900">
                            <span>Разом</span>
                            <span class="price text-lg">{{ formatPrice(totals.total) }}</span>
                        </div>
                    </div>

                    <button
                        @click="checkout"
                        class="btn-primary w-full mt-6 btn-lg justify-center"
                        id="cart-checkout-btn"
                    >
                        Оформити замовлення
                        <i class="ri-arrow-right-line"></i>
                    </button>

                    <RouterLink :to="route('products.index')" class="btn-ghost w-full mt-3 justify-center btn-sm">
                        <i class="ri-arrow-left-line"></i>
                        Продовжити покупки
                    </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/shared/api';
import { imageUrl, formatPrice } from '@/shared/lib';

const props = defineProps({
    products: { type: Array, default: () => [] },
    domain:   { type: String, default: '' },
});

const vueRouter = useRouter();
const domain = ref(props.domain || import.meta.env.VITE_API_ORIGIN || '');
const state = reactive({
    products: props.products.map((p) => ({
        ...p,
        quantity: p.quantity || 1,
        discount: p.discount || 0,
        total: (p.price || 0) * (p.quantity || 1) - (p.discount || 0) * (p.quantity || 1),
    })),
});

const fetchCart = async () => {
    const response = await api.get('/cart');
    state.products = response.data.data.map((item) => ({
        ...item.product,
        cart_item_id: item.id,
        quantity: item.quantity || 1,
        discount: 0,
        total: item.subtotal,
    }));
};

const totals = computed(() => {
    const subtotal = state.products.reduce((s, p) => s + p.price * p.quantity, 0);
    const discount = state.products.reduce((s, p) => s + p.discount * p.quantity, 0);
    return {
        subtotal: subtotal.toFixed(2),
        discount: discount.toFixed(2),
        total: (subtotal - discount).toFixed(2),
    };
});

const removeItem = (product) => {
    api.delete(`/cart/items/${product.cart_item_id}`).then(fetchCart);
};

const checkout = () => {
    api.post('/checkout').then(() => vueRouter.push('/orders'));
};

onMounted(fetchCart);
</script>
