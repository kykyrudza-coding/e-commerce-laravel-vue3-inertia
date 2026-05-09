<template>
    <Head title="Оплата успішна" />

    <div class="container-app py-16 flex items-center justify-center min-h-[60vh]">
        <div class="card p-10 max-w-md w-full text-center animate-scale-in">
            <!-- Success icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-6">
                <i class="ri-checkbox-circle-line text-5xl text-emerald-500"></i>
            </div>

            <h1 class="text-2xl font-bold text-surface-900 mb-3">Дякуємо за покупку!</h1>
            <p class="text-surface-500 leading-relaxed mb-2">{{ message }}</p>
            <p class="text-sm text-surface-400 mb-8">Ми вже обробляємо ваше замовлення і скоро надішлемо підтвердження на email.</p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <RouterLink :to="route('home')" class="btn-primary btn-lg justify-center" id="payment-success-home-btn">
                    <i class="ri-home-3-line"></i>
                    На головну
                </RouterLink>
                <RouterLink :to="route('products.index')" class="btn-secondary btn-lg justify-center" id="payment-success-shop-btn">
                    <i class="ri-store-3-line"></i>
                    Продовжити покупки
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    message: { type: String, default: 'Ваш платіж успішно оброблено.' },
});
</script>
