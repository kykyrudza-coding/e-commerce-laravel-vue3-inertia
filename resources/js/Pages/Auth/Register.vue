<template>
    <Head title="Реєстрація" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up">
            <div class="card p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-surface-900 mb-1">Створити акаунт</h1>
                    <p class="text-surface-500 text-sm">Приєднуйтесь до TechStore сьогодні</p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="reg-name" class="block text-sm font-medium text-surface-700 mb-1.5">Ім'я</label>
                        <div class="relative">
                            <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="reg-name"
                                v-model="form.name"
                                type="text"
                                autocomplete="name"
                                placeholder="Ваше ім'я"
                                :class="['input pl-10', form.errors.name && 'input-error']"
                            />
                        </div>
                        <p v-if="form.errors.name" class="mt-1.5 text-xs text-red-500">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="reg-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="reg-email"
                                v-model="form.email"
                                type="email"
                                autocomplete="email"
                                placeholder="name@example.com"
                                :class="['input pl-10', form.errors.email && 'input-error']"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="reg-password" class="block text-sm font-medium text-surface-700 mb-1.5">Пароль</label>
                        <div class="relative">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="reg-password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password"
                                placeholder="Мінімум 8 символів"
                                :class="['input pl-10 pr-10', form.errors.password && 'input-error']"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-surface-400 hover:text-surface-600"
                                tabindex="-1"
                            >
                                <i :class="showPassword ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
                    </div>

                    <!-- Confirm password -->
                    <div>
                        <label for="reg-password-confirm" class="block text-sm font-medium text-surface-700 mb-1.5">Підтвердіть пароль</label>
                        <div class="relative">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="reg-password-confirm"
                                v-model="form.password_confirmation"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="new-password"
                                placeholder="Повторіть пароль"
                                :class="['input pl-10', form.errors.password_confirmation && 'input-error']"
                            />
                        </div>
                        <p v-if="form.errors.password_confirmation" class="mt-1.5 text-xs text-red-500">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="btn-primary w-full btn-lg justify-center !mt-6"
                        id="register-submit-btn"
                    >
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
                        {{ form.processing ? 'Реєструємо...' : 'Зареєструватись' }}
                    </button>
                </form>

                <!-- Login link -->
                <p class="mt-6 text-center text-sm text-surface-500">
                    Вже є акаунт?
                    <Link :href="route('login')" class="text-brand-600 font-medium hover:text-brand-700 ml-1">
                        Увійти
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
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
