<template>
    <Head title="Увійти" />
    <AuthLayout>
        <div class="w-full max-w-md animate-slide-up">
            <div class="card p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-surface-900 mb-1">З поверненням!</h1>
                    <p class="text-surface-500 text-sm">Увійдіть до свого акаунту</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="login-email"
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
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="login-password" class="text-sm font-medium text-surface-700">Пароль</label>
                            <Link :href="route('password.request')" class="text-xs text-brand-600 hover:text-brand-700">
                                Забули пароль?
                            </Link>
                        </div>
                        <div class="relative">
                            <i class="ri-lock-2-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input
                                id="login-password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                placeholder="••••••••"
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

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="btn-primary w-full btn-lg justify-center"
                        id="login-submit-btn"
                    >
                        <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
                        {{ form.processing ? 'Входимо...' : 'Увійти' }}
                    </button>
                </form>

                <!-- Register link -->
                <p class="mt-6 text-center text-sm text-surface-500">
                    Ще немає акаунту?
                    <Link :href="route('register')" class="text-brand-600 font-medium hover:text-brand-700 ml-1">
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
