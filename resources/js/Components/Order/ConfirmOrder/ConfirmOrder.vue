<template>
    <div class="card p-6 lg:p-8 animate-fade-in">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-surface-900 mb-1">Підтвердження замовлення</h2>
            <p class="text-sm text-surface-500">Перевірте ваші дані та оберіть спосіб оплати</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- User info -->
            <div class="p-5 rounded-2xl bg-surface-50 border border-surface-100">
                <div class="flex items-center gap-2 mb-4 text-surface-900 font-semibold">
                    <i class="ri-user-3-line text-brand-600"></i>
                    Замовник
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-surface-500">Ім'я</span>
                        <span class="font-medium text-surface-800">{{ user.name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-surface-500">Телефон</span>
                        <span class="font-medium text-surface-800">{{ user.phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-surface-500">Email</span>
                        <span class="font-medium text-surface-800">{{ user.email }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery info -->
            <div class="p-5 rounded-2xl bg-surface-50 border border-surface-100">
                <div class="flex items-center gap-2 mb-4 text-surface-900 font-semibold">
                    <i class="ri-truck-line text-brand-600"></i>
                    Доставка ({{ method.name }})
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-surface-500">Місто</span>
                        <span class="font-medium text-surface-800">{{ data.city }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-surface-500">Регіон</span>
                        <span class="font-medium text-surface-800">{{ data.region }}</span>
                    </div>
                    <div v-if="data.house" class="flex justify-between">
                        <span class="text-surface-500">Адреса</span>
                        <span class="font-medium text-surface-800">{{ data.street }}, {{ data.house }}</span>
                    </div>
                    <div v-if="data.postOffices" class="flex justify-between">
                        <span class="text-surface-500">Відділення</span>
                        <span class="font-medium text-surface-800">{{ data.postOffices }}</span>
                    </div>
                    <div class="flex justify-between mt-2 pt-2 border-t border-surface-200">
                        <span class="text-surface-500">Вартість доставки</span>
                        <span class="font-medium text-brand-600">{{ formatPrice(method.price) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-surface-100 pt-6 mt-6">
            <div class="flex items-center justify-between mb-6">
                <span class="text-surface-600">До сплати</span>
                <span class="text-2xl font-bold text-surface-900">{{ formatPrice(totalPrice) }}</span>
            </div>

            <button
                @click="processPayment"
                :disabled="processing || !products.length"
                class="btn-primary w-full btn-lg justify-center"
            >
                <i v-if="processing" class="ri-loader-4-line animate-spin"></i>
                <i v-else class="ri-paypal-fill text-xl"></i>
                {{ processing ? 'Обробка...' : 'Оплатити через PayPal' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { formatPrice } from '@/utils/helpers.js';

const props = defineProps({
    token:    String,
    data:     Object,
    method:   Object,
    products: Array,
    user:     Object,
    domain:   String,
});

const processing = ref(false);

const totalPrice = computed(() => {
    const sum = props.products.reduce((acc, p) => acc + (Number(p.price) || 0), 0);
    return sum + (Number(props.method.price) || 0);
});

const processPayment = () => {
    processing.value = true;
    router.post('/create-paypal-payment', {
        user: props.user,
        products: props.products,
        delivery: props.method,
        total_price: totalPrice.value
    });
};
</script>
