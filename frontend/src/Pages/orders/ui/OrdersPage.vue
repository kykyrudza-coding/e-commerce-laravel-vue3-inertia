<template>
    <Head title="Замовлення" />

    <div class="container-app py-8">
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Замовлення</span>
        </nav>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between mb-8">
            <div>
                <h1 class="page-title">Мої замовлення</h1>
                <p class="text-sm text-surface-500 mt-2">Переглядайте створені замовлення та їхній поточний статус.</p>
            </div>

            <RouterLink :to="route('products.index')" class="btn-ghost btn-sm">
                <i class="ri-store-3-line"></i>
                До каталогу
            </RouterLink>
        </div>

        <div v-if="loading" class="card p-8 text-center text-surface-500">
            Завантаження замовлень...
        </div>

        <div v-else-if="error" class="card p-8 text-center">
            <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                <i class="ri-error-warning-line text-2xl"></i>
            </div>
            <h2 class="text-lg font-semibold text-surface-900 mb-2">Не вдалося завантажити замовлення</h2>
            <p class="text-sm text-surface-500 mb-5">{{ error }}</p>
            <button class="btn-primary btn-sm mx-auto" @click="fetchOrders(meta.current_page || 1)">
                <i class="ri-refresh-line"></i>
                Спробувати ще раз
            </button>
        </div>

        <div v-else-if="!orders.length" class="card p-10 text-center">
            <div class="w-20 h-20 rounded-3xl bg-surface-100 flex items-center justify-center mx-auto mb-5">
                <i class="ri-file-list-3-line text-4xl text-surface-300"></i>
            </div>
            <h2 class="text-xl font-bold text-surface-800 mb-2">Замовлень ще немає</h2>
            <p class="text-surface-500 mb-7">Після оформлення покупки замовлення зʼявиться тут.</p>
            <RouterLink :to="route('products.index')" class="btn-primary btn-lg justify-center">
                <i class="ri-store-3-line"></i>
                Перейти до каталогу
            </RouterLink>
        </div>

        <div v-else class="space-y-4">
            <article
                v-for="order in orders"
                :key="order.id"
                class="card overflow-hidden"
            >
                <div class="px-5 py-4 border-b border-surface-100 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-base font-semibold text-surface-900">Замовлення #{{ order.id }}</h2>
                            <span :class="statusClass(order.status)" class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold">
                                {{ statusLabel(order.status) }}
                            </span>
                        </div>
                        <p class="text-xs text-surface-400 mt-1">{{ order.order_token }}</p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="price text-lg">{{ formatPrice(order.total_price) }}</p>
                        <p class="text-xs text-surface-400">{{ formatDate(order.created_at) }}</p>
                    </div>
                </div>

                <div class="px-5 py-4 grid gap-4 lg:grid-cols-[1fr_220px]">
                    <div class="space-y-3">
                        <div
                            v-for="item in order.items || []"
                            :key="item.id"
                            class="flex items-center gap-3"
                        >
                            <div class="w-12 h-12 rounded-lg bg-surface-100 flex items-center justify-center text-surface-300 flex-shrink-0">
                                <i class="ri-image-2-line"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-surface-800 truncate">
                                    {{ item.product?.name || `Товар #${item.product_id}` }}
                                </p>
                                <p class="text-xs text-surface-500">
                                    {{ item.quantity }} шт. x {{ formatPrice(item.price) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <dl class="text-sm space-y-2">
                        <div class="flex justify-between gap-4">
                            <dt class="text-surface-500">Оплата</dt>
                            <dd class="font-medium text-surface-800">{{ paymentLabel(order.payment_method) }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-surface-500">Позицій</dt>
                            <dd class="font-medium text-surface-800">{{ order.items?.length || 0 }}</dd>
                        </div>
                    </dl>
                </div>
            </article>

            <div v-if="meta.last_page > 1" class="flex items-center justify-center gap-3 pt-4">
                <button
                    class="btn-ghost btn-sm"
                    :disabled="meta.current_page <= 1"
                    @click="fetchOrders(meta.current_page - 1)"
                >
                    <i class="ri-arrow-left-line"></i>
                    Назад
                </button>
                <span class="text-sm text-surface-500">
                    {{ meta.current_page }} / {{ meta.last_page }}
                </span>
                <button
                    class="btn-ghost btn-sm"
                    :disabled="meta.current_page >= meta.last_page"
                    @click="fetchOrders(meta.current_page + 1)"
                >
                    Далі
                    <i class="ri-arrow-right-line"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api, { apiData, apiMessage, apiMeta } from '@/shared/api';
import { formatPrice } from '@/shared/lib';

const orders = ref([]);
const meta = ref({});
const loading = ref(false);
const error = ref('');

const statusLabels = {
    pending: 'Очікує',
    paid: 'Оплачено',
    shipped: 'Відправлено',
    cancelled: 'Скасовано',
};

const paymentLabels = {
    manual: 'Оплата при отриманні',
    credit_card: 'Картка',
    paypal: 'PayPal',
};

const statusClasses = {
    pending: 'bg-amber-50 text-amber-700',
    paid: 'bg-emerald-50 text-emerald-700',
    shipped: 'bg-blue-50 text-blue-700',
    cancelled: 'bg-red-50 text-red-700',
};

const fetchOrders = async (page = 1) => {
    loading.value = true;
    error.value = '';

    try {
        const response = await api.get('/orders', { params: { page } });
        orders.value = apiData(response, []);
        meta.value = apiMeta(response, {});
    } catch (exception) {
        error.value = apiMessage(exception.response, 'Сталася помилка під час завантаження замовлень.');
    } finally {
        loading.value = false;
    }
};

const statusLabel = (status) => statusLabels[status] || status || 'Невідомо';
const statusClass = (status) => statusClasses[status] || 'bg-surface-100 text-surface-600';
const paymentLabel = (method) => paymentLabels[method] || method || 'Не вказано';

const formatDate = (value) => {
    if (!value) {
        return '';
    }

    return new Intl.DateTimeFormat('uk-UA', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(value));
};

onMounted(() => fetchOrders());
</script>
