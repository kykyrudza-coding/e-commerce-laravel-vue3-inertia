<template>
    <Head title="Профіль" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-8">
            <Link :href="route('home')" class="hover:text-surface-600 transition-colors">Головна</Link>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Профіль</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="card p-5 flex flex-col items-center text-center">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-3xl font-bold mb-4 shadow-glow">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <h2 class="font-semibold text-surface-900 text-lg">{{ user.name }}</h2>
                    <p class="text-sm text-surface-400 mt-0.5 mb-5">{{ user.email }}</p>

                    <!-- Nav tabs -->
                    <nav class="w-full space-y-1">
                        <button
                            v-for="tab in tabs"
                            :key="tab.id"
                            @click="activeTab = tab.id"
                            :class="[
                                'w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-left',
                                activeTab === tab.id
                                    ? 'bg-brand-50 text-brand-700'
                                    : 'text-surface-600 hover:bg-surface-50 hover:text-surface-900'
                            ]"
                            :id="`profile-tab-${tab.id}`"
                        >
                            <i :class="tab.icon" class="text-base flex-shrink-0"></i>
                            {{ tab.label }}
                        </button>
                    </nav>

                    <div class="w-full mt-5 pt-5 border-t border-surface-100">
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition-all duration-200"
                            id="profile-logout-btn"
                        >
                            <i class="ri-logout-box-r-line text-base"></i>
                            Вийти з акаунту
                        </Link>
                    </div>
                </div>
            </aside>

            <!-- Main content -->
            <div class="lg:col-span-3">
                <!-- Info tab -->
                <Transition name="tab-fade" mode="out-in">
                    <div v-if="activeTab === 'info'" key="info">
                        <div class="card">
                            <div class="px-6 py-4 border-b border-surface-100">
                                <h3 class="font-semibold text-surface-900">Особисті дані</h3>
                            </div>
                            <div class="divide-y divide-surface-100">
                                <div
                                    v-for="field in infoFields"
                                    :key="field.label"
                                    class="grid grid-cols-3 px-6 py-4"
                                >
                                    <dt class="text-sm text-surface-500 flex items-center gap-2">
                                        <i :class="field.icon" class="text-surface-300"></i>
                                        {{ field.label }}
                                    </dt>
                                    <dd class="col-span-2 text-sm font-medium text-surface-800">
                                        {{ field.value || '—' }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit tab -->
                    <div v-else-if="activeTab === 'edit'" key="edit">
                        <div class="card">
                            <div class="px-6 py-4 border-b border-surface-100">
                                <h3 class="font-semibold text-surface-900">Редагування профілю</h3>
                            </div>
                            <div class="p-6">
                                <!-- Success flash -->
                                <div
                                    v-if="successMessage"
                                    class="mb-5 p-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm flex items-center gap-2 animate-fade-in"
                                >
                                    <i class="ri-check-circle-line text-lg"></i>
                                    {{ successMessage }}
                                </div>

                                <form @submit.prevent="submitForm" class="space-y-5">
                                    <!-- Name -->
                                    <div>
                                        <label for="profile-name" class="block text-sm font-medium text-surface-700 mb-1.5">Ім'я</label>
                                        <div class="relative">
                                            <i class="ri-user-3-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                            <input
                                                id="profile-name"
                                                v-model="form.name"
                                                type="text"
                                                :class="['input pl-10', errors.name && 'input-error']"
                                            />
                                        </div>
                                        <p v-if="errors.name" class="mt-1.5 text-xs text-red-500">{{ errors.name }}</p>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="profile-email" class="block text-sm font-medium text-surface-700 mb-1.5">Email</label>
                                        <div class="relative">
                                            <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                            <input
                                                id="profile-email"
                                                v-model="form.email"
                                                type="email"
                                                :class="['input pl-10', errors.email && 'input-error']"
                                            />
                                        </div>
                                        <p v-if="errors.email" class="mt-1.5 text-xs text-red-500">{{ errors.email }}</p>
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="profile-phone" class="block text-sm font-medium text-surface-700 mb-1.5">Телефон</label>
                                        <div class="relative">
                                            <i class="ri-phone-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                            <input
                                                id="profile-phone"
                                                v-model="form.phone"
                                                type="tel"
                                                placeholder="+380..."
                                                :class="['input pl-10', errors.phone && 'input-error']"
                                            />
                                        </div>
                                        <p v-if="errors.phone" class="mt-1.5 text-xs text-red-500">{{ errors.phone }}</p>
                                    </div>

                                    <div class="flex justify-end pt-2">
                                        <button type="submit" :disabled="saving" class="btn-primary" id="profile-save-btn">
                                            <i v-if="saving" class="ri-loader-4-line animate-spin"></i>
                                            {{ saving ? 'Зберігаємо...' : 'Зберегти зміни' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    user:   { type: Object, required: true },
    errors: { type: Object, default: () => ({}) },
});

const activeTab = ref('info');
const saving = ref(false);
const successMessage = ref('');

const tabs = [
    { id: 'info', label: 'Особисті дані',     icon: 'ri-user-line' },
    { id: 'edit', label: 'Редагувати профіль', icon: 'ri-pencil-line' },
];

const formatDate = (date) =>
    date ? new Date(date).toLocaleDateString('uk-UA', { year: 'numeric', month: 'long', day: 'numeric' }) : '—';

const infoFields = computed(() => [
    { label: "Ім'я",               icon: 'ri-user-line',     value: props.user.name },
    { label: 'Email',              icon: 'ri-mail-line',     value: props.user.email },
    { label: 'Телефон',            icon: 'ri-phone-line',    value: props.user.phone },
    { label: 'Акаунт створено',    icon: 'ri-calendar-line', value: formatDate(props.user.created_at) },
    { label: 'Останнє оновлення',  icon: 'ri-time-line',     value: formatDate(props.user.updated_at) },
]);

const form = reactive({
    name:  props.user.name  ?? '',
    email: props.user.email ?? '',
    phone: props.user.phone ?? '',
});

const submitForm = () => {
    saving.value = true;
    router.post(route('user.update'), form, {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Дані успішно збережено!';
            setTimeout(() => { successMessage.value = ''; }, 3000);
        },
        onFinish: () => { saving.value = false; },
    });
};
</script>

<style scoped>
.tab-fade-enter-active, .tab-fade-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.tab-fade-enter-from { opacity: 0; transform: translateY(8px); }
.tab-fade-leave-to   { opacity: 0; transform: translateY(-4px); }
</style>
