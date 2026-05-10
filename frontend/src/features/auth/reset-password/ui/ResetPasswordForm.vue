<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label for="reset-email" class="block text-sm font-semibold text-surface-800 mb-2">Email</label>
            <div class="relative">
                <Mail class="absolute left-4 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-surface-500" />
                <input
                    id="reset-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    :class="inputClass(form.errors.email, 'pr-4')"
                />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.email }}</p>
        </div>

        <div>
            <label for="reset-password" class="block text-sm font-semibold text-surface-800 mb-2">Новий пароль</label>
            <div class="relative">
                <Lock class="absolute left-4 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-surface-500" />
                <input
                    id="reset-password"
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    autocomplete="new-password"
                    placeholder="Мінімум 8 символів"
                    :class="inputClass(form.errors.password, 'pr-12')"
                />
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 z-10 -translate-y-1/2 text-surface-500 hover:text-surface-800"
                    tabindex="-1"
                >
                    <EyeOff v-if="showPassword" class="h-5 w-5" />
                    <Eye v-else class="h-5 w-5" />
                </button>
            </div>
            <p v-if="form.errors.password" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.password }}</p>
        </div>

        <div>
            <label for="reset-confirm" class="block text-sm font-semibold text-surface-800 mb-2">Підтвердіть пароль</label>
            <div class="relative">
                <Lock class="absolute left-4 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-surface-500" />
                <input
                    id="reset-confirm"
                    v-model="form.password_confirmation"
                    :type="showPassword ? 'text' : 'password'"
                    autocomplete="new-password"
                    placeholder="Повторіть пароль"
                    :class="inputClass(false, 'pr-4')"
                />
            </div>
        </div>

        <button type="submit" :disabled="form.processing" class="w-full h-12 rounded-xl bg-surface-950 text-white font-bold flex items-center justify-center gap-2 hover:bg-surface-800 transition-colors disabled:opacity-60 disabled:hover:bg-surface-950" id="reset-password-submit-btn">
            <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
            {{ form.processing ? 'Оновлюємо...' : 'Оновити пароль' }}
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { Eye, EyeOff, Lock, Mail } from 'lucide-vue-next';
import { useForm } from '@/shared/lib/spa-compat';

const props = defineProps({
    token: { type: String, required: true },
    email: { type: String, default: '' },
});

const showPassword = ref(false);

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const inputClass = (error, paddingRight) => [
    `relative w-full h-12 pl-12 ${paddingRight} rounded-xl border bg-white text-surface-900 placeholder-surface-400 transition-colors outline-none`,
    error ? 'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-surface-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-100',
];

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
