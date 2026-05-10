<template>
    <!-- Toolbar -->
    <div class="flex items-center justify-between py-3 mb-4">
        <div>
            <span class="text-sm font-medium text-surface-600">
                <template v-if="isLoading">Завантаження товарів</template>
                <template v-else>Знайдено <span class="font-bold text-surface-900">{{ productCount }}</span> товарів</template>
            </span>
        </div>

        <div class="flex items-center gap-1.5">
            <!-- Filter toggle -->
            <button
                v-if="showFilter"
                @click="emit('toggle-filters')"
                class="btn-secondary btn-sm gap-2"
                id="products-filter-toggle"
            >
                <i class="ri-equalizer-3-line"></i>
                <span class="hidden sm:inline">Фільтри</span>
            </button>

            <!-- Grid size -->
            <div class="flex items-center gap-1 p-1 bg-surface-100 rounded-xl">
                <button
                    v-for="col in gridOptions"
                    :key="col.count"
                    @click="columnCount = col.count"
                    :class="['btn-icon w-8 h-8 rounded-lg transition-all', columnCount === col.count ? 'bg-white shadow-sm text-brand-600' : 'text-surface-400 hover:text-surface-600']"
                    :title="col.label"
                    :id="`products-grid-${col.count}`"
                >
                    <i :class="col.icon" class="text-sm"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <ProductGridSkeleton v-if="isLoading" :grid-class="gridClass" />

    <div
        v-else-if="products?.length"
        :class="[
            'grid gap-4 transition-all duration-300',
            gridClass,
        ]"
    >
        <ProductCatalogCard
            v-for="product in products"
            :key="product.id"
            :product="product"
            :domain="domain"
        />
    </div>

    <!-- Empty state -->
    <div v-else class="py-24 flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 rounded-2xl bg-surface-100 flex items-center justify-center mb-4">
            <i class="ri-box-3-line text-4xl text-surface-300"></i>
        </div>
        <h3 class="font-semibold text-surface-700 mb-1">Товарів не знайдено</h3>
        <p class="text-sm text-surface-400">Спробуйте змінити параметри фільтрів</p>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ProductCatalogCard from './ProductCatalogCard.vue';
import ProductGridSkeleton from './ProductGridSkeleton.vue';

const props = defineProps({
    products: { type: Array, default: () => [] },
    domain: { type: String, default: '' },
    showFilter: { type: Boolean, default: false },
    isLoading: { type: Boolean, default: false },
});

const emit = defineEmits(['toggle-filters']);

const columnCount = ref(3);

const gridOptions = [
    { count: 2, icon: 'ri-layout-grid-line',   label: '2 колонки' },
    { count: 3, icon: 'ri-layout-grid-2-line', label: '3 колонки' },
    { count: 4, icon: 'ri-grid-line',          label: '4 колонки' },
];

const gridClass = computed(() => {
    const map = { 2: 'grid-cols-2', 3: 'grid-cols-2 lg:grid-cols-3', 4: 'grid-cols-2 lg:grid-cols-4' };
    return map[columnCount.value] ?? 'grid-cols-2 lg:grid-cols-3';
});

const productCount = computed(() => props.products?.length ?? 0);
</script>
