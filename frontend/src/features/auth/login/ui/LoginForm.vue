<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label for="login-email" class="block text-sm font-semibold text-surface-800 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Mail class="h-5 w-5" />
                </div>
                <input
                    id="login-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    placeholder="name@example.com"
                    :class="[
                        'relative w-full h-12 pl-12 pr-4 rounded-xl border bg-white text-surface-900 placeholder-surface-400 transition-colors outline-none',
                        form.errors.email ? 'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-surface-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-100'
                    ]"
                />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.email }}</p>
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="login-password" class="text-sm font-semibold text-surface-800">Пароль</label>
                <RouterLink :to="route('password.request')" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                    Забули пароль?
                </RouterLink>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 z-10 pl-4 flex items-center pointer-events-none text-surface-500">
                    <Lock class="h-5 w-5" />
                </div>
                <input
                    id="login-password"
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    :class="[
                        'relative w-full h-12 pl-12 pr-12 rounded-xl border bg-white text-surface-900 placeholder-surface-400 transition-colors outline-none',
                        form.errors.password ? 'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-surface-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-100'
                    ]"
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

        <button
            type="submit"
            :disabled="form.processing"
            class="w-full h-12 rounded-xl bg-surface-950 text-white font-bold flex items-center justify-center gap-2 hover:bg-surface-800 transition-colors disabled:opacity-60 disabled:hover:bg-surface-950 mt-8"
            id="login-submit-btn"
        >
            <i v-if="form.processing" class="ri-loader-4-line animate-spin text-xl"></i>
            <span>{{ form.processing ? 'Входимо...' : 'Увійти' }}</span>
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { Eye, EyeOff, Lock, Mail } from 'lucide-vue-next';
import { useRouter } from 'vue-router';
import { useForm } from '@/shared/lib/spa-compat';

const showPassword = ref(false);
const router = useRouter();

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login.store'), {
        onSuccess: () => router.push(route('home')),
        onFinish: () => form.reset('password'),
    });
};
</script>
