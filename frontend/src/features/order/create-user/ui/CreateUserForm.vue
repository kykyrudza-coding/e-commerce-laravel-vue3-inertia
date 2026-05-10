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

            <AppTextField
                id="order-name"
                v-model="form.name"
                label="Ім'я"
                placeholder="Ваше ім'я"
                icon="ri-user-3-line"
                :error="errors.name"
            />

            <AppTextField
                id="order-phone"
                v-model="form.phone"
                label="Телефон"
                type="tel"
                placeholder="+380..."
                icon="ri-phone-line"
                :error="errors.phone"
            />

            <AppTextField
                id="order-email"
                v-model="form.email"
                label="Email"
                type="email"
                placeholder="name@example.com"
                icon="ri-mail-line"
                :error="errors.email"
            />

            <AppButton
                type="submit"
                variant="primary"
                size="lg"
                block
                center
                :loading="form.processing"
                class="mt-6"
            >
                {{ form.processing ? 'Обробка...' : 'Наступний крок' }}
                <template #trailing>
                    <i v-if="!form.processing" class="ri-arrow-right-line"></i>
                </template>
            </AppButton>
        </form>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@/shared/lib/spa-compat';
import { AppButton, AppTextField } from '@/shared/ui';
import { onMounted } from 'vue';

const props = defineProps({
    token:  { type: String, required: true },
    errors: { type: Object, default: () => ({}) },
});

const page = usePage();

const form = useForm({
    name: '',
    phone: '',
    email: '',
});

onMounted(() => {
    if (page.props.auth?.user) {
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
