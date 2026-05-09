<template>
    <Head title="Помилка оплати" />

    <div class="container-app py-16 flex items-center justify-center min-h-[60vh]">
        <div class="card p-10 max-w-md w-full text-center animate-scale-in">
            <!-- Error icon -->
            <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                <i class="ri-error-warning-line text-5xl text-red-500"></i>
            </div>

            <h1 class="text-2xl font-bold text-surface-900 mb-3">Помилка оплати</h1>
            <p class="text-red-500 leading-relaxed mb-2">{{ message }}</p>
            <p class="text-sm text-surface-400 mb-8">
                Спробуйте ще раз або зверніться до підтримки, якщо проблема повторюється.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <Link :href="route('home')" class="btn-secondary btn-lg justify-center" id="payment-error-home-btn">
                    <i class="ri-home-3-line"></i>
                    На головну
                </Link>
                <Link :href="route('products.index')" class="btn-danger btn-lg justify-center" id="payment-error-retry-btn">
                    <i class="ri-refresh-line"></i>
                    Спробувати ще раз
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    message: { type: String, default: 'Під час обробки платежу сталася помилка.' },
});
</script>
