<template>
    <Head title="Відновлення паролю" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up px-4 sm:px-0">
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-surface-200 shadow-xl shadow-surface-200/60">
                <div class="mb-8">
                    <div class="w-12 h-12 rounded-xl bg-surface-100 text-surface-700 flex items-center justify-center mb-4">
                        <MailCheck class="h-6 w-6" />
                    </div>
                    <h1 class="text-2xl font-bold text-surface-950 mb-2">Відновити пароль</h1>
                    <p class="text-sm text-surface-500">Введіть email, і ми надішлемо посилання для скидання паролю.</p>
                </div>

                <ForgotPasswordForm :status="status" />

                <p class="mt-6 text-center text-sm text-surface-500">
                    <RouterLink :to="route('login')" class="text-brand-600 hover:text-brand-700 font-medium inline-flex items-center gap-1">
                        <ArrowLeft class="h-4 w-4" />
                        Повернутись до входу
                    </RouterLink>
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ArrowLeft, MailCheck } from 'lucide-vue-next';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { ForgotPasswordForm } from '@/features/auth/forgot-password';

defineProps({
    status: { type: String, default: null },
});
</script>
