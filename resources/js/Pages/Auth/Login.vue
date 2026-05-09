<template>
    <Head title="Увійти" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up-delayed relative px-4 sm:px-0">
            <!-- Decorative Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-brand-500 to-indigo-500 rounded-[2.5rem] blur opacity-20 pointer-events-none"></div>
            
            <div class="bg-white/70 backdrop-blur-xl p-8 sm:p-10 rounded-[2.5rem] border border-white shadow-2xl shadow-brand-500/10 relative">
                <!-- Header -->
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-surface-900 mb-2 tracking-tight">З поверненням!</h1>
                    <p class="text-surface-500 font-medium">Увійдіть до свого акаунту</p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="login-email" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="login-email"
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                placeholder="name@example.com"
                                :class="[
                                    'w-full h-14 pl-11 pr-4 rounded-2xl border bg-white/50 backdrop-blur-sm shadow-inner transition-all outline-none font-medium focus:bg-white',
                                    form.errors.email ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10' : 'border-surface-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10'
                                ]"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-xs font-bold text-red-500 ml-1">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2 ml-1 mr-1">
                            <label for="login-password" class="text-sm font-bold text-surface-900">Пароль</label>
                            <Link :href="route('password.request')" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                Забули пароль?
                            </Link>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-lock-2-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="login-password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                placeholder="••••••••"
                                :class="[
                                    'w-full h-14 pl-11 pr-12 rounded-2xl border bg-white/50 backdrop-blur-sm shadow-inner transition-all outline-none font-medium focus:bg-white',
                                    form.errors.password ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10' : 'border-surface-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10'
                                ]"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-0 top-0 h-full px-4 text-surface-400 hover:text-brand-600 transition-colors"
                                tabindex="-1"
                            >
                                <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'" class="text-lg"></i>
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-xs font-bold text-red-500 ml-1">{{ form.errors.password }}</p>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full h-14 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white font-black text-lg flex items-center justify-center gap-2 hover:from-brand-500 hover:to-indigo-500 transition-all shadow-lg shadow-brand-500/30 hover:shadow-xl hover:shadow-brand-500/40 hover:-translate-y-0.5 mt-8"
                        id="login-submit-btn"
                    >
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin text-xl"></i>
                        <span>{{ form.processing ? 'Входимо...' : 'Увійти' }}</span>
                    </button>
                </form>

                <!-- Register link -->
                <p class="mt-8 text-center text-sm font-medium text-surface-500">
                    Ще немає акаунту?
                    <Link :href="route('register')" class="text-brand-600 font-bold hover:text-brand-700 ml-1 transition-colors">
                        Зареєструватись
                    </Link>
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';

defineProps({
    errors: { type: Object, default: () => ({}) },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
