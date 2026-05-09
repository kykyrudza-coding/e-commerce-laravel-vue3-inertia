<template>
    <Head title="Відновлення паролю" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up">
            <div class="card p-8">
                <div class="mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center mb-4">
                        <i class="ri-mail-send-line text-2xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-surface-900 mb-1">Відновити пароль</h1>
                    <p class="text-sm text-surface-500">Введіть email — надішлемо посилання для скидання паролю.</p>
                </div>

                <!-- Success message -->
                <div v-if="status" class="mb-5 p-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm flex items-center gap-2">
                    <i class="ri-check-circle-line text-lg"></i>
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="forgot-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="forgot-email"
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                placeholder="name@example.com"
                                :class="['input pl-10', form.errors.email && 'input-error']"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <button type="submit" :disabled="form.processing" class="btn-primary w-full btn-lg justify-center" id="forgot-password-submit-btn">
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
                        {{ form.processing ? 'Надсилаємо...' : 'Надіслати посилання' }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-surface-500">
                    <RouterLink :to="route('login')" class="text-brand-600 hover:text-brand-700 font-medium">
                        <i class="ri-arrow-left-line"></i>
                        Повернутись до входу
                    </RouterLink>
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { useForm } from '@/services/spaCompat';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineOptions({ layout: null });

defineProps({
    status: { type: String, default: null },
    errors: { type: Object, default: () => ({}) },
});

const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>
