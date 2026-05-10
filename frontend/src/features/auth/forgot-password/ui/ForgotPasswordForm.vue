<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div v-if="status" class="p-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm flex items-center gap-2">
            <CheckCircle class="h-5 w-5 shrink-0" />
            {{ status }}
        </div>

        <div>
            <label for="forgot-email" class="block text-sm font-semibold text-surface-800 mb-2">Email</label>
            <div class="relative">
                <Mail class="absolute left-4 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-surface-500" />
                <input
                    id="forgot-email"
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

        <button type="submit" :disabled="form.processing" class="w-full h-12 rounded-xl bg-surface-950 text-white font-bold flex items-center justify-center gap-2 hover:bg-surface-800 transition-colors disabled:opacity-60 disabled:hover:bg-surface-950" id="forgot-password-submit-btn">
            <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
            {{ form.processing ? 'Надсилаємо...' : 'Надіслати посилання' }}
        </button>
    </form>
</template>

<script setup>
import { CheckCircle, Mail } from 'lucide-vue-next';
import { useForm } from '@/shared/lib/spa-compat';

defineProps({
    status: { type: String, default: null },
});

const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>
