<template>
    <div class="card p-6 lg:p-8 animate-fade-in">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-surface-900 mb-1">Контактні дані</h2>
            <p class="text-sm text-surface-500">Заповніть форму, щоб ми могли зв'язатися з вами щодо замовлення</p>
        </div>

        <form @submit.prevent="send" class="space-y-4">
            <!-- Alert if authenticated -->
            <div v-if="$page.props.auth?.user" class="p-4 bg-brand-50 rounded-xl mb-4 border border-brand-100 flex items-start gap-3">
                <i class="ri-user-smile-line text-brand-600 text-xl mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium text-brand-900">Ви авторизовані</p>
                    <p class="text-sm text-brand-700">Ваші дані підтягнуто автоматично. Ви можете оновити їх за потреби.</p>
                </div>
            </div>

            <!-- Name -->
            <div>
                <label for="order-name" class="block text-sm font-medium text-surface-700 mb-1.5">Ім'я</label>
                <div class="relative">
                    <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                    <input id="order-name" v-model="form.name" type="text" placeholder="Ваше ім'я"
                        :class="['input pl-10', errors.name && 'input-error']" />
                </div>
                <p v-if="errors.name" class="mt-1.5 text-xs text-red-500">{{ errors.name }}</p>
            </div>

            <!-- Phone -->
            <div>
                <label for="order-phone" class="block text-sm font-medium text-surface-700 mb-1.5">Телефон</label>
                <div class="relative">
                    <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                    <input id="order-phone" v-model="form.phone" type="tel" placeholder="+380..."
                        :class="['input pl-10', errors.phone && 'input-error']" />
                </div>
                <p v-if="errors.phone" class="mt-1.5 text-xs text-red-500">{{ errors.phone }}</p>
            </div>

            <!-- Email -->
            <div>
                <label for="order-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                <div class="relative">
                    <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                    <input id="order-email" v-model="form.email" type="email" placeholder="name@example.com"
                        :class="['input pl-10', errors.email && 'input-error']" />
                </div>
                <p v-if="errors.email" class="mt-1.5 text-xs text-red-500">{{ errors.email }}</p>
            </div>

            <button type="submit" :disabled="form.processing" class="btn-primary w-full btn-lg justify-center mt-6">
                <i v-if="form.processing" class="ri-loader-4-line animate-spin"></i>
                {{ form.processing ? 'Обробка...' : 'Наступний крок' }}
                <i v-if="!form.processing" class="ri-arrow-right-line"></i>
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@/services/spaCompat';
import { onMounted } from 'vue';

const props = defineProps({
    token:  { type: String, required: true },
    errors: { type: Object, default: () => ({}) },
    user:   { type: Object, default: null }, // Passed explicitly now
});

const page = usePage();

const form = useForm({
    name: '',
    phone: '',
    email: '',
});

onMounted(() => {
    // If the explicit user prop contains data, use it (since it has the phone number)
    if (props.user) {
        form.name = props.user.name || '';
        form.email = props.user.email || '';
        form.phone = props.user.phone || '';
    } else if (page.props.auth?.user) {
        form.name = page.props.auth.user.name || '';
        form.email = page.props.auth.user.email || '';
        form.phone = page.props.auth.user.phone || '';
    }
});

const send = () => {
    form.post(route('order.store', props.token), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
