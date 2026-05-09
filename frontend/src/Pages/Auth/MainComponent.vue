<template>
    <Head :title="currentForm === 'login' ? 'Увійти' : 'Реєстрація'" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up">
            <div class="card p-8">
                <!-- Tab switcher -->
                <div class="flex rounded-xl bg-surface-100 p-1 mb-8">
                    <button
                        @click="switchForm('login')"
                        :class="['flex-1 py-2 text-sm font-medium rounded-lg transition-all duration-200', currentForm === 'login' ? 'bg-white text-surface-900 shadow-sm' : 'text-surface-500 hover:text-surface-700']"
                        id="auth-tab-login"
                    >
                        Увійти
                    </button>
                    <button
                        @click="switchForm('register')"
                        :class="['flex-1 py-2 text-sm font-medium rounded-lg transition-all duration-200', currentForm === 'register' ? 'bg-white text-surface-900 shadow-sm' : 'text-surface-500 hover:text-surface-700']"
                        id="auth-tab-register"
                    >
                        Реєстрація
                    </button>
                </div>

                <!-- Login Form -->
                <Transition name="auth-form" mode="out-in">
                    <div v-if="currentForm === 'login'" key="login">
                        <div class="mb-6">
                            <h1 class="text-xl font-bold text-surface-900">З поверненням!</h1>
                            <p class="text-sm text-surface-500 mt-1">Увійдіть до свого акаунту</p>
                        </div>

                        <form @submit.prevent="submitLogin" class="space-y-4">
                            <div>
                                <label for="login-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="login-email" v-model="loginForm.email" type="email" autocomplete="email"
                                        placeholder="name@example.com" :class="['input pl-10', errors.email && 'input-error']" />
                                </div>
                                <p v-if="errors.email" class="mt-1.5 text-xs text-red-500">{{ errors.email }}</p>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="login-password" class="text-sm font-medium text-surface-700">Пароль</label>
                                    <RouterLink :to="route('password.request')" class="text-xs text-brand-600 hover:text-brand-700">Забули?</RouterLink>
                                </div>
                                <div class="relative">
                                    <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="login-password" v-model="loginForm.password" :type="showPassword ? 'text' : 'password'"
                                        autocomplete="current-password" placeholder="••••••••"
                                        :class="['input pl-10 pr-10', errors.password && 'input-error']" />
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-surface-400 hover:text-surface-600" tabindex="-1">
                                        <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                                    </button>
                                </div>
                                <p v-if="errors.password" class="mt-1.5 text-xs text-red-500">{{ errors.password }}</p>
                            </div>

                            <button type="submit" :disabled="loginForm.processing" class="btn-primary w-full btn-lg justify-center !mt-6" id="login-submit-btn">
                                <i v-if="loginForm.processing" class="ri-loader-4-line animate-spin"></i>
                                {{ loginForm.processing ? 'Входимо...' : 'Увійти' }}
                            </button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div v-else key="register">
                        <div class="mb-6">
                            <h1 class="text-xl font-bold text-surface-900">Створити акаунт</h1>
                            <p class="text-sm text-surface-500 mt-1">Приєднуйтесь до TechStore</p>
                        </div>

                        <form @submit.prevent="submitRegister" class="space-y-4">
                            <div>
                                <label for="reg-name" class="block text-sm font-medium text-surface-700 mb-1.5">Ім'я</label>
                                <div class="relative">
                                    <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="reg-name" v-model="registerForm.name" type="text" autocomplete="name"
                                        placeholder="Ваше ім'я" :class="['input pl-10', errors.name && 'input-error']" />
                                </div>
                                <p v-if="errors.name" class="mt-1.5 text-xs text-red-500">{{ errors.name }}</p>
                            </div>

                            <div>
                                <label for="reg-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="reg-email" v-model="registerForm.email" type="email" autocomplete="email"
                                        placeholder="name@example.com" :class="['input pl-10', errors.email && 'input-error']" />
                                </div>
                                <p v-if="errors.email" class="mt-1.5 text-xs text-red-500">{{ errors.email }}</p>
                            </div>

                            <div>
                                <label for="reg-password" class="block text-sm font-medium text-surface-700 mb-1.5">Пароль</label>
                                <div class="relative">
                                    <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="reg-password" v-model="registerForm.password" :type="showPassword ? 'text' : 'password'"
                                        autocomplete="new-password" placeholder="Мінімум 8 символів"
                                        :class="['input pl-10 pr-10', errors.password && 'input-error']" />
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-surface-400 hover:text-surface-600" tabindex="-1">
                                        <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                                    </button>
                                </div>
                                <p v-if="errors.password" class="mt-1.5 text-xs text-red-500">{{ errors.password }}</p>
                            </div>

                            <div>
                                <label for="reg-confirm" class="block text-sm font-medium text-surface-700 mb-1.5">Підтвердіть пароль</label>
                                <div class="relative">
                                    <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="reg-confirm" v-model="registerForm.password_confirmation" :type="showPassword ? 'text' : 'password'"
                                        autocomplete="new-password" placeholder="Повторіть пароль"
                                        :class="['input pl-10', errors.password_confirmation && 'input-error']" />
                                </div>
                                <p v-if="errors.password_confirmation" class="mt-1.5 text-xs text-red-500">{{ errors.password_confirmation }}</p>
                            </div>

                            <button type="submit" :disabled="registerForm.processing" class="btn-primary w-full btn-lg justify-center !mt-6" id="register-submit-btn">
                                <i v-if="registerForm.processing" class="ri-loader-4-line animate-spin"></i>
                                {{ registerForm.processing ? 'Реєструємо...' : 'Зареєструватись' }}
                            </button>
                        </form>
                    </div>
                </Transition>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@/services/spaCompat';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineOptions({ layout: null }); // AuthLayout is rendered manually

const props = defineProps({
    errors: { type: Object, default: () => ({}) },
});

const showPassword = ref(false);
const currentForm = ref('login');

onMounted(() => {
    const path = window.location.pathname;
    currentForm.value = path.includes('register') ? 'register' : 'login';
});

const switchForm = (form) => {
    currentForm.value = form;
    const url = form === 'login' ? '/login' : '/register';
    window.history.pushState({}, '', url);
};

// Login
const loginForm = useForm({ email: '', password: '' });
const submitLogin = () => {
    loginForm.post(route('login.store'), {
        onFinish: () => loginForm.reset('password'),
    });
};

// Register
const registerForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const submitRegister = () => {
    registerForm.post(route('register.store'), {
        onFinish: () => registerForm.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>
.auth-form-enter-active, .auth-form-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.auth-form-enter-from { opacity: 0; transform: translateX(12px); }
.auth-form-leave-to  { opacity: 0; transform: translateX(-12px); }
</style>
