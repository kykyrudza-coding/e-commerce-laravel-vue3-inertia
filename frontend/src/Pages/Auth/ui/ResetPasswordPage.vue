<template>
    <Head title="Скинути пароль" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up px-4 sm:px-0">
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-surface-200 shadow-xl shadow-surface-200/60">
                <div class="mb-8">
                    <div class="w-12 h-12 rounded-xl bg-surface-100 text-surface-700 flex items-center justify-center mb-4">
                        <KeyRound class="h-6 w-6" />
                    </div>
                    <h1 class="text-2xl font-bold text-surface-950 mb-2">Новий пароль</h1>
                    <p class="text-sm text-surface-500">Введіть новий надійний пароль для вашого акаунту.</p>
                </div>

                <ResetPasswordForm :token="token" :email="email" />
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { KeyRound } from 'lucide-vue-next';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { ResetPasswordForm } from '@/features/auth/reset-password';

defineProps({
    token: { type: String, required: true },
    email: { type: String, default: '' },
});
</script>
