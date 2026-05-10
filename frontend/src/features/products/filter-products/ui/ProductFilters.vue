<template>
    <div class="p-5">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-semibold text-surface-900">Фільтри</h2>
            <button @click="resetFilters" class="text-xs text-brand-600 hover:text-brand-700 font-medium" id="filters-reset">
                Скинути всі
            </button>
        </div>

        <!-- Price range -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-surface-700 mb-3">Ціна</h3>
            <div class="flex items-center gap-2 mb-3">
                <div class="flex-1">
                    <label class="text-xs text-surface-400 block mb-1">Від</label>
                    <input
                        v-model.number="filters.priceMin"
                        type="number"
                        min="0"
                        :max="filters.priceMax"
                        class="input text-sm"
                        @change="applyFilters"
                        id="filter-price-min"
                    />
                </div>
                <span class="text-surface-300 mt-5">—</span>
                <div class="flex-1">
                    <label class="text-xs text-surface-400 block mb-1">До</label>
                    <input
                        v-model.number="filters.priceMax"
                        type="number"
                        :min="filters.priceMin"
                        max="10000"
                        class="input text-sm"
                        @change="applyFilters"
                        id="filter-price-max"
                    />
                </div>
            </div>
            <input
                type="range"
                v-model.number="filters.priceMax"
                min="0"
                max="10000"
                step="50"
                @change="applyFilters"
                class="w-full"
            />
        </div>

        <div class="divider mb-6"></div>

        <!-- Dynamic filters from backend -->
        <div
            v-for="(options, filterKey) in filtersOptions"
            :key="filterKey"
            class="mb-5"
        >
            <label
                :for="`filter-${filterKey}`"
                class="block text-sm font-semibold text-surface-700 mb-2 capitalize"
            >
                {{ filterLabels[filterKey] ?? filterKey }}
            </label>
            <select
                :id="`filter-${filterKey}`"
                v-model="filters[filterKey]"
                class="input text-sm"
                @change="applyFilters"
            >
                <option value="">Всі</option>
                <option v-for="opt in options" :key="opt" :value="opt">{{ opt }}</option>
            </select>
        </div>

        <button @click="applyFilters" class="btn-primary w-full mt-2" id="filters-apply">
            <i class="ri-equalizer-3-line"></i>
            Застосувати
        </button>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { router } from '@/shared/lib/spa-compat';

const props = defineProps({
    filtersOptions: { type: Object, required: true },
});

const filterLabels = {
    deviceType:        'Тип пристрою',
    brand:             'Бренд',
    screenSize:        'Розмір екрану',
    screenType:        'Тип екрану',
    os:                'Операційна система',
    processor:         'Процесор',
    ram:               'Оперативна пам\'ять',
    storage:           'Пам\'ять',
    cameraResolution:  'Камера',
    batteryCapacity:   'Батарея',
    color:             'Колір',
    condition:         'Стан',
    availability:      'Наявність',
};

const filters = reactive({
    priceMin: 0,
    priceMax: 5000,
    ...Object.fromEntries(Object.keys(props.filtersOptions).map((k) => [k, ''])),
});

const applyFilters = () => {
    const params = {};

    if (filters.priceMin > 0) params.priceMin = filters.priceMin;
    if (filters.priceMax < 10000) params.priceMax = filters.priceMax;

    for (const [key, val] of Object.entries(filters)) {
        if (val !== '' && val !== null && val !== undefined && key !== 'priceMin' && key !== 'priceMax') {
            params[key] = val;
        }
    }

    router.get(window.location.pathname, params, {
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    filters.priceMin = 0;
    filters.priceMax = 5000;
    for (const key of Object.keys(props.filtersOptions)) {
        filters[key] = '';
    }
    router.get(window.location.pathname, {}, { preserveState: false });
};
</script>
