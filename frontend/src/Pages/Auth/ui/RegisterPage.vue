<template>
    <Head title="Реєстрація" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up-delayed px-4 sm:px-0">
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-surface-200 shadow-xl shadow-surface-200/60">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-surface-950 mb-2 tracking-tight">Створити акаунт</h1>
                    <p class="text-sm text-surface-500">Приєднуйтесь до TechStore сьогодні</p>
                </div>

                <RegisterForm />

                <!-- Login link -->
                <p class="mt-8 text-center text-sm font-medium text-surface-500">
                    Вже є акаунт?
                    <RouterLink :to="route('login')" class="text-brand-600 font-bold hover:text-brand-700 ml-1 transition-colors">
                        Увійти
                    </RouterLink>
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { RegisterForm } from '@/features/auth/register';

defineProps({
    errors: { type: Object, default: () => ({}) },
});
</script>
