<template>
    <Head title="Реєстрація" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up-delayed relative px-4 sm:px-0">
            <!-- Decorative Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-brand-500 to-indigo-500 rounded-[2.5rem] blur opacity-20 pointer-events-none"></div>

            <div class="bg-white/70 backdrop-blur-xl p-8 sm:p-10 rounded-[2.5rem] border border-white shadow-2xl shadow-brand-500/10 relative">
                <!-- Header -->
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-surface-900 mb-2 tracking-tight">Створити акаунт</h1>
                    <p class="text-surface-500 font-medium">Приєднуйтесь до TechStore сьогодні</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="reg-name" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Ім'я</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-user-3-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="reg-name"
                                v-model="form.name"
                                type="text"
                                autocomplete="name"
                                placeholder="Ваше ім'я"
                                :class="[
                                    'w-full h-14 pl-11 pr-4 rounded-2xl border bg-white/50 backdrop-blur-sm shadow-inner transition-all outline-none font-medium focus:bg-white',
                                    form.errors.name ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10' : 'border-surface-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10'
                                ]"
                            />
                        </div>
                        <p v-if="form.errors.name" class="mt-2 text-xs font-bold text-red-500 ml-1">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="reg-email" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="reg-email"
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

                    <!-- Phone -->
                    <div>
                        <label for="reg-phone" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Телефон</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-phone-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="reg-phone"
                                v-model="form.phone"
                                type="tel"
                                autocomplete="tel"
                                placeholder="099-123-4567"
                                :class="[
                                    'w-full h-14 pl-11 pr-4 rounded-2xl border bg-white/50 backdrop-blur-sm shadow-inner transition-all outline-none font-medium focus:bg-white',
                                    form.errors.phone ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10' : 'border-surface-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10'
                                ]"
                            />
                        </div>
                        <p v-if="form.errors.phone" class="mt-2 text-xs font-bold text-red-500 ml-1">{{ form.errors.phone }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="reg-password" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Пароль</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-lock-2-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="reg-password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password"
                                placeholder="Мінімум 8 символів"
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

                    <!-- Confirm password -->
                    <div>
                        <label for="reg-password-confirm" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Підтвердіть пароль</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ri-lock-2-line text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                            </div>
                            <input
                                id="reg-password-confirm"
                                v-model="form.password_confirmation"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password"
                                placeholder="Повторіть пароль"
                                :class="[
                                    'w-full h-14 pl-11 pr-4 rounded-2xl border bg-white/50 backdrop-blur-sm shadow-inner transition-all outline-none font-medium focus:bg-white',
                                    form.errors.password_confirmation ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-500/10' : 'border-surface-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10'
                                ]"
                            />
                        </div>
                        <p v-if="form.errors.password_confirmation" class="mt-2 text-xs font-bold text-red-500 ml-1">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full h-14 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white font-black text-lg flex items-center justify-center gap-2 hover:from-brand-500 hover:to-indigo-500 transition-all shadow-lg shadow-brand-500/30 hover:shadow-xl hover:shadow-brand-500/40 hover:-translate-y-0.5 mt-8"
                        id="register-submit-btn"
                    >
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin text-xl"></i>
                        <span>{{ form.processing ? 'Реєструємо...' : 'Зареєструватись' }}</span>
                    </button>
                </form>

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
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useForm } from '@/services/spaCompat';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineProps({
    errors: { type: Object, default: () => ({}) },
});

const showPassword = ref(false);
const router = useRouter();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register.store'), {
        onSuccess: () => router.push(route('home')),
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
