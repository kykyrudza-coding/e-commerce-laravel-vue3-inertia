<template>
    <Head title="Каталог товарів" />

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-[-1] bg-surface-50 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
    </div>

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6" aria-label="Breadcrumb">
            <RouterLink :to="route('home')" class="hover:text-brand-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-900 font-bold">Каталог</span>
        </nav>

        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-black text-surface-900 tracking-tight mb-2">Каталог товарів</h1>
            <p class="text-surface-500 font-medium">Знайдіть ідеальний пристрій для вас</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar filters (desktop) -->
            <aside
                class="hidden lg:block flex-shrink-0 transition-all duration-300 overflow-hidden"
                :style="filtersVisible ? 'width: 280px; opacity: 1' : 'width: 0; opacity: 0'"
                aria-label="Фільтри"
            >
                <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl shadow-brand-500/5 sticky top-24">
                    <ProductFiltersSkeleton v-if="showFiltersSkeleton" />
                    <ProductFilters v-else :filters-options="filtersOptions" />
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 min-w-0">
                <ProductGrid
                    :products="products"
                    :domain="domain"
                    :show-filter="true"
                    :is-loading="isLoading"
                    @toggle-filters="toggleFilters"
                />
                <div v-if="!isLoading && total > 0" class="mt-10">
                    <AppPagination
                        :current-page="currentPage"
                        :last-page="lastPage"
                        :total="total"
                        :per-page="perPage"
                        @page-changed="handlePageChange"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile filter drawer -->
    <Teleport to="body">
        <Transition name="drawer">
            <div
                v-if="mobileFiltersOpen"
                class="fixed inset-0 z-[100] lg:hidden"
            >
                <div class="absolute inset-0 bg-surface-950/40 backdrop-blur-sm" @click="mobileFiltersOpen = false"></div>
                <div class="absolute left-0 top-0 bottom-0 w-[85%] max-w-[320px] bg-white/95 backdrop-blur-2xl shadow-2xl overflow-y-auto border-r border-white/50">
                    <div class="flex items-center justify-between p-6 border-b border-surface-200">
                        <h2 class="font-black text-xl text-surface-900">Фільтри</h2>
                        <button @click="mobileFiltersOpen = false" class="w-10 h-10 rounded-xl bg-surface-100 flex items-center justify-center text-surface-600 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                    <ProductFiltersSkeleton v-if="showFiltersSkeleton" />
                    <ProductFilters v-else :filters-options="filtersOptions" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import api from '@/shared/api';
import { ProductGrid } from '@/widgets/product-catalog';
import { ProductFilters } from '@/features/products/filter-products';
import { AppPagination } from '@/features/products/paginate-products';
import ProductFiltersSkeleton from './ProductFiltersSkeleton.vue';

const products = ref([]);
const domain = ref(import.meta.env.VITE_API_ORIGIN || '');
const isLoading = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);
const total = ref(0);
const perPage = ref(15);
const filtersOptions = ref({});
const filtersVisible = ref(true);
const mobileFiltersOpen = ref(false);

const showFiltersSkeleton = computed(() => isLoading.value && !Object.keys(filtersOptions.value).length);

const fetchProducts = async (page = 1) => {
    isLoading.value = true;

    try {
        const response = await api.get('/products', { params: { page } });
        products.value = response.data.data;
        currentPage.value = response.data.meta?.current_page ?? page;
        lastPage.value = response.data.meta?.last_page ?? 1;
        total.value = response.data.meta?.total ?? products.value.length;
        perPage.value = response.data.meta?.per_page ?? 15;
        filtersOptions.value = response.data.filters ?? {};
        domain.value = import.meta.env.VITE_API_ORIGIN || '';
    } finally {
        isLoading.value = false;
    }
};

const toggleFilters = () => {
    if (window.innerWidth < 1024) {
        mobileFiltersOpen.value = !mobileFiltersOpen.value;
    } else {
        filtersVisible.value = !filtersVisible.value;
    }
};

const handlePageChange = (page) => {
    fetchProducts(page);
};

onMounted(() => fetchProducts());
</script>

<style scoped>
.drawer-enter-active, .drawer-leave-active {
    transition: opacity 0.25s ease;
}
.drawer-enter-active .absolute.left-0,
.drawer-leave-active .absolute.left-0 {
    transition: transform 0.3s ease;
}
.drawer-enter-from { opacity: 0; }
.drawer-leave-to   { opacity: 0; }
.drawer-enter-from .absolute.left-0 { transform: translateX(-100%); }
.drawer-leave-to   .absolute.left-0 { transform: translateX(-100%); }
</style>
