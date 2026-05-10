<template>
    <Head title="Увійти" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up-delayed px-4 sm:px-0">
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-surface-200 shadow-xl shadow-surface-200/60">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-surface-950 mb-2 tracking-tight">З поверненням</h1>
                    <p class="text-sm text-surface-500">Увійдіть до свого акаунту</p>
                </div>

                <LoginForm />

                <!-- Register link -->
                <p class="mt-8 text-center text-sm font-medium text-surface-500">
                    Ще немає акаунту?
                    <RouterLink :to="route('register')" class="text-brand-600 font-bold hover:text-brand-700 ml-1 transition-colors">
                        Зареєструватись
                    </RouterLink>
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { LoginForm } from '@/features/auth/login';

defineProps({
    errors: { type: Object, default: () => ({}) },
});
</script>
