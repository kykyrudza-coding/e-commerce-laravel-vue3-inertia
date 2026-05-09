<template>
    <div class="card p-6 lg:p-8 animate-fade-in">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-surface-900 mb-1">Доставка</h2>
            <p class="text-sm text-surface-500">Оберіть спосіб та вкажіть деталі доставки</p>
        </div>

        <!-- Tabs -->
        <div class="flex rounded-xl bg-surface-100 p-1 mb-6">
            <button
                @click="activeTab = 'pickup'"
                :class="['flex-1 py-2 text-sm font-medium rounded-lg transition-all duration-200', activeTab === 'pickup' ? 'bg-white text-surface-900 shadow-sm' : 'text-surface-500 hover:text-surface-700']"
            >
                Самовивіз
            </button>
            <button
                @click="activeTab = 'delivery'"
                :class="['flex-1 py-2 text-sm font-medium rounded-lg transition-all duration-200', activeTab === 'delivery' ? 'bg-white text-surface-900 shadow-sm' : 'text-surface-500 hover:text-surface-700']"
            >
                Доставка додому
            </button>
        </div>

        <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Pickup Tab -->
            <Transition name="fade" mode="out-in">
                <div v-if="activeTab === 'pickup'" key="pickup" class="space-y-4">
                    <div class="p-4 bg-brand-50 rounded-xl mb-4 border border-brand-100">
                        <p class="text-sm text-brand-700 flex items-center gap-2">
                            <i class="ri-information-line text-lg"></i>
                            Самовивіз доступний лише по місту Кропивницький
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Місто</label>
                            <select v-model="form.city" :class="['input', errors.city && 'input-error']">
                                <option value="" disabled>Оберіть місто</option>
                                <option v-for="(item, idx) in cities" :key="idx" :value="item.name">{{ item.name }}</option>
                            </select>
                            <p v-if="errors.city" class="mt-1 text-xs text-red-500">{{ errors.city }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Район</label>
                            <select v-model="form.region" :class="['input', errors.region && 'input-error']">
                                <option value="" disabled>Оберіть район</option>
                                <option v-for="(item, idx) in regions" :key="idx" :value="item.name">{{ item.name }}</option>
                            </select>
                            <p v-if="errors.region" class="mt-1 text-xs text-red-500">{{ errors.region }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Відділення пошти</label>
                        <select v-model="form.postOffices" :class="['input', errors.postOffices && 'input-error']">
                            <option value="" disabled>Оберіть відділення</option>
                            <option v-for="(item, idx) in postOffices" :key="idx" :value="item.name">{{ item.name }}</option>
                        </select>
                        <p v-if="errors.postOffices" class="mt-1 text-xs text-red-500">{{ errors.postOffices }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Дата самовивезення</label>
                        <div class="relative">
                            <i class="ri-calendar-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input v-model="form.date" type="date" :class="['input pl-10', errors.date && 'input-error']" />
                        </div>
                        <p v-if="errors.date" class="mt-1 text-xs text-red-500">{{ errors.date }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Коментар</label>
                        <textarea v-model="form.comments" rows="2" placeholder="Додаткова інформація..." class="input resize-none"></textarea>
                    </div>
                </div>

                <!-- Delivery Tab -->
                <div v-else key="delivery" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Регіон / Область</label>
                            <div class="relative">
                                <i class="ri-map-pin-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                <input v-model="form.region" type="text" placeholder="Наприклад: Київська область" :class="['input pl-10', errors.region && 'input-error']" />
                            </div>
                            <p v-if="errors.region" class="mt-1 text-xs text-red-500">{{ errors.region }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Місто</label>
                            <div class="relative">
                                <i class="ri-building-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                <input v-model="form.city" type="text" placeholder="Наприклад: Київ" :class="['input pl-10', errors.city && 'input-error']" />
                            </div>
                            <p v-if="errors.city" class="mt-1 text-xs text-red-500">{{ errors.city }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Вулиця</label>
                            <div class="relative">
                                <i class="ri-road-map-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                <input v-model="form.street" type="text" placeholder="Назва вулиці" :class="['input pl-10', errors.street && 'input-error']" />
                            </div>
                            <p v-if="errors.street" class="mt-1 text-xs text-red-500">{{ errors.street }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Дім / Квартира</label>
                            <div class="relative">
                                <i class="ri-home-4-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                <input v-model="form.house" type="text" placeholder="№" :class="['input pl-10', errors.house && 'input-error']" />
                            </div>
                            <p v-if="errors.house" class="mt-1 text-xs text-red-500">{{ errors.house }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Поштовий індекс</label>
                        <div class="relative">
                            <i class="ri-mail-open-line absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"></i>
                            <input v-model="form.postal_code" type="text" placeholder="00000" :class="['input pl-10', errors.postal_code && 'input-error']" />
                        </div>
                        <p v-if="errors.postal_code" class="mt-1 text-xs text-red-500">{{ errors.postal_code }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Коментар для кур'єра</label>
                        <textarea v-model="form.comments" rows="2" placeholder="Особливості доїзду, код домофону..." class="input resize-none"></textarea>
                    </div>
                </div>
            </Transition>

            <button type="submit" class="btn-primary w-full btn-lg justify-center mt-6">
                Наступний крок
                <i class="ri-arrow-right-line"></i>
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router } from '@/services/spaCompat';

const props = defineProps({
    token:       { type: String, required: true },
    cities:      { type: [Object, Array], default: () => [] },
    regions:     { type: [Object, Array], default: () => [] },
    postOffices: { type: [Object, Array], default: () => [] },
    errors:      { type: Object, default: () => ({}) },
});

const activeTab = ref('pickup');

const form = reactive({
    city: '',
    region: '',
    postOffices: '',
    date: '',
    comments: '',
    street: '',
    house: '',
    postal_code: '',
});

const submitForm = () => {
    const payload = { activeTab: activeTab.value };
    if (activeTab.value === 'pickup') {
        Object.assign(payload, {
            city: form.city,
            region: form.region,
            postOffices: form.postOffices,
            date: form.date,
            comments: form.comments,
        });
    } else {
        Object.assign(payload, {
            region: form.region,
            city: form.city,
            street: form.street,
            house: form.house,
            postal_code: form.postal_code,
            comments: form.comments,
        });
    }

    router.post(route('order.store.addAddress', props.token), payload, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
