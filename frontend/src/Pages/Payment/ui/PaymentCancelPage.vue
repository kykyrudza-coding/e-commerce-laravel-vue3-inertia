<template>
    <Head title="Платіж скасовано" />

    <div class="container-app py-16 flex items-center justify-center min-h-[60vh]">
        <div class="card p-10 max-w-md w-full text-center animate-scale-in">
            <!-- Cancel icon -->
            <div class="w-20 h-20 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-6">
                <i class="ri-close-circle-line text-5xl text-amber-500"></i>
            </div>

            <h1 class="text-2xl font-bold text-surface-900 mb-3">{{ message }}</h1>
            <p class="text-surface-500 leading-relaxed mb-8">
                Ви скасували платіж. Якщо це сталося помилково — спробуйте ще раз або зверніться до підтримки.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <RouterLink :to="route('home')" class="btn-secondary btn-lg justify-center" id="payment-cancel-home-btn">
                    <i class="ri-home-3-line"></i>
                    На головну
                </RouterLink>
                <RouterLink :to="route('cart.index', $page.props.auth.user?.id)" class="btn-primary btn-lg justify-center" id="payment-cancel-cart-btn">
                    <i class="ri-shopping-bag-3-line"></i>
                    Повернутись до кошика
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@/shared/lib/spa-compat';

const $page = usePage();

defineProps({
    message: { type: String, default: 'Платіж скасовано' },
});
</script>
