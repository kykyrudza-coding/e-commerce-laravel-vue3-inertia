<template>
    <Head title="Скинути пароль" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up">
            <div class="card p-8">
                <div class="mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center mb-4">
                        <i class="ri-lock-password-line text-2xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-surface-900 mb-1">Новий пароль</h1>
                    <p class="text-sm text-surface-500">Введіть новий надійний пароль для вашого акаунту.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="reset-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input id="reset-email" v-model="form.email" type="email" autocomplete="email"
                                :class="['input pl-10', form.errors.email && 'input-error']" />
                        </div>
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="reset-password" class="block text-sm font-medium text-surface-700 mb-1.5">Новий пароль</label>
                        <div class="relative">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input id="reset-password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password" placeholder="Мінімум 8 символів"
                                :class="['input pl-10 pr-10', form.errors.password && 'input-error']" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-surface-400 hover:text-surface-600" tabindex="-1">
                                <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label for="reset-confirm" class="block text-sm font-medium text-surface-700 mb-1.5">Підтвердіть пароль</label>
                        <div class="relative">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input id="reset-confirm" v-model="form.password_confirmation" :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password" placeholder="Повторіть пароль" class="input pl-10" />
                        </div>
                    </div>

                    <button type="submit" :disabled="form.processing" class="btn-primary w-full btn-lg justify-center" id="reset-password-submit-btn">
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
                        {{ form.processing ? 'Оновлюємо...' : 'Оновити пароль' }}
                    </button>
                </form>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@/services/spaCompat';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineOptions({ layout: null });

const props = defineProps({
    token: { type: String, required: true },
    email: { type: String, default: '' },
    errors: { type: Object, default: () => ({}) },
});

const showPassword = ref(false);

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
