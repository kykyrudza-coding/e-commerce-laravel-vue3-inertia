<template>
    <Head title="Оформлення замовлення" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <RouterLink :to="route('products.index')" class="hover:text-surface-600 transition-colors">Каталог</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Оформлення</span>
        </nav>

        <h1 class="page-title mb-8">Перевірка замовлення</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Products list -->
            <div class="lg:col-span-2">
                <div class="card overflow-hidden">
                    <div class="px-5 py-4 border-b border-surface-100 bg-surface-50">
                        <h2 class="font-semibold text-surface-800 text-sm">Товари у замовленні</h2>
                    </div>

                    <div class="divide-y divide-surface-100">
                        <div
                            v-for="product in products"
                            :key="product.id"
                            class="flex items-center gap-4 px-5 py-4"
                        >
                            <!-- Image -->
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-surface-100">
                                <img
                                    v-if="product.main_image"
                                    :src="`${domain}${product.main_image.image_path}`"
                                    :alt="product.name"
                                    class="w-full h-full object-cover"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                                    <i class="ri-image-2-line text-xl"></i>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-surface-800 truncate">{{ product.name }}</p>
                                <p class="text-xs text-surface-400 mt-0.5">{{ product.category?.name }}</p>
                            </div>

                            <!-- Price -->
                            <span class="price text-base flex-shrink-0">{{ formatPrice(product.price) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order summary -->
            <div>
                <div class="card p-6 sticky top-20">
                    <h2 class="font-semibold text-surface-900 mb-5">Підсумок</h2>

                    <div class="space-y-3 text-sm mb-5">
                        <div class="flex justify-between text-surface-600">
                            <span>Кількість товарів</span>
                            <span>{{ products.length }}</span>
                        </div>
                        <div class="pt-3 border-t border-surface-100 flex justify-between font-bold text-base">
                            <span>Разом</span>
                            <span class="price">{{ formatPrice(totalAmount) }}</span>
                        </div>
                    </div>

                    <button
                        @click="proceedToCheckout"
                        class="btn-primary w-full btn-lg justify-center"
                        id="checkout-proceed-btn"
                    >
                        <i class="ri-secure-payment-line"></i>
                        Перейти до оплати
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
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/services/api';
import { formatPrice } from '@/utils/helpers.js';

const props = defineProps({
    products: { type: Array, default: () => [] },
    domain:   { type: String, default: '' },
});

const vueRouter = useRouter();
const products = ref(props.products);
const domain = ref(props.domain || import.meta.env.VITE_API_ORIGIN || '');

const totalAmount = computed(() =>
    products.value.reduce((sum, p) => sum + parseFloat(p.price || 0) * (p.quantity || 1), 0)
);

const fetchCart = async () => {
    const response = await api.get('/cart');
    products.value = response.data.data.map((item) => ({
        ...item.product,
        quantity: item.quantity,
    }));
};

const proceedToCheckout = async () => {
    await api.post('/checkout');
    vueRouter.push('/orders');
};

onMounted(fetchCart);
</script>
