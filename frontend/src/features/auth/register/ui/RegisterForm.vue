<template>
    <form @submit.prevent="submit" class="space-y-5">
        <div>
            <label for="reg-name" class="block text-sm font-semibold text-surface-800 mb-2">Ім'я</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <User class="h-5 w-5" />
                </div>
                <input
                    id="reg-name"
                    v-model="form.name"
                    type="text"
                    autocomplete="name"
                    placeholder="Ваше ім'я"
                    :class="inputClass(form.errors.name, 'pr-4')"
                />
            </div>
            <p v-if="form.errors.name" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.name }}</p>
        </div>

        <div>
            <label for="reg-email" class="block text-sm font-semibold text-surface-800 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Mail class="h-5 w-5" />
                </div>
                <input
                    id="reg-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    placeholder="name@example.com"
                    :class="inputClass(form.errors.email, 'pr-4')"
                />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.email }}</p>
        </div>

        <div>
            <label for="reg-phone" class="block text-sm font-semibold text-surface-800 mb-2">Телефон</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Phone class="h-5 w-5" />
                </div>
                <input
                    id="reg-phone"
                    v-model="form.phone"
                    type="tel"
                    autocomplete="tel"
                    placeholder="099-123-4567"
                    :class="inputClass(form.errors.phone, 'pr-4')"
                />
            </div>
            <p v-if="form.errors.phone" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.phone }}</p>
        </div>

        <div>
            <label for="reg-password" class="block text-sm font-semibold text-surface-800 mb-2">Пароль</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Lock class="h-5 w-5" />
                </div>
                <input
                    id="reg-password"
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    autocomplete="new-password"
                    placeholder="Мінімум 8 символів"
                    :class="inputClass(form.errors.password, 'pr-12')"
                />
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-0 top-0 z-10 h-full px-4 text-surface-500 hover:text-surface-800 transition-colors"
                    tabindex="-1"
                >
                    <EyeOff v-if="showPassword" class="h-5 w-5" />
                    <Eye v-else class="h-5 w-5" />
                </button>
            </div>
            <p v-if="form.errors.password" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.password }}</p>
        </div>

        <div>
            <label for="reg-password-confirm" class="block text-sm font-semibold text-surface-800 mb-2">Підтвердіть пароль</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Lock class="h-5 w-5" />
                </div>
                <input
                    id="reg-password-confirm"
                    v-model="form.password_confirmation"
                    :type="showPassword ? 'text' : 'password'"
                    autocomplete="new-password"
                    placeholder="Повторіть пароль"
                    :class="inputClass(form.errors.password_confirmation, 'pr-4')"
                />
            </div>
            <p v-if="form.errors.password_confirmation" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.password_confirmation }}</p>
        </div>

        <button
            type="submit"
            :disabled="form.processing"
            class="w-full h-12 rounded-xl bg-surface-950 text-white font-bold flex items-center justify-center gap-2 hover:bg-surface-800 transition-colors disabled:opacity-60 disabled:hover:bg-surface-950 mt-8"
            id="register-submit-btn"
        >
            <i v-if="form.processing" class="ri-loader-4-line animate-spin text-xl"></i>
            <span>{{ form.processing ? 'Реєструємо...' : 'Зареєструватись' }}</span>
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { Eye, EyeOff, Lock, Mail, Phone, User } from 'lucide-vue-next';
import { useRouter } from 'vue-router';
import { useForm } from '@/shared/lib/spa-compat';

const showPassword = ref(false);
const router = useRouter();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const inputClass = (error, paddingRight) => [
    `relative w-full h-12 pl-12 ${paddingRight} rounded-xl border bg-white text-surface-900 placeholder-surface-400 transition-colors outline-none`,
    error ? 'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-surface-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-100',
];

const submit = () => {
    form.post(route('register.store'), {
        onSuccess: () => router.push(route('home')),
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
