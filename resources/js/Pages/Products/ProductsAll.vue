<template>
    <Head title="Каталог товарів" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6" aria-label="Breadcrumb">
            <Link :href="route('home')" class="hover:text-surface-600 transition-colors">Головна</Link>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Каталог</span>
        </nav>

        <h1 class="page-title mb-1">Каталог товарів</h1>
        <p class="page-subtitle mb-8">Знайдіть ідеальний пристрій для вас</p>

        <div class="flex gap-6">
            <!-- Sidebar filters (desktop) -->
            <aside
                class="hidden lg:block flex-shrink-0 transition-all duration-300 overflow-hidden"
                :style="filtersVisible ? 'width: 280px; opacity: 1' : 'width: 0; opacity: 0'"
                aria-label="Фільтри"
            >
                <div class="card sticky top-20">
                    <ProductFilters :filters-options="filtersOptions" />
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 min-w-0">
                <ProductGrid
                    :products="products"
                    :domain="domain"
                    :show-filter="true"
                    @toggle-filters="toggleFilters"
                />
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

    <!-- Mobile filter drawer -->
    <Teleport to="body">
        <Transition name="drawer">
            <div
                v-if="mobileFiltersOpen"
                class="fixed inset-0 z-50 lg:hidden"
                @click.self="mobileFiltersOpen = false"
            >
                <div class="absolute inset-0 bg-surface-950/50 backdrop-blur-sm"></div>
                <div class="absolute left-0 top-0 bottom-0 w-80 bg-white shadow-2xl overflow-y-auto">
                    <div class="flex items-center justify-between p-4 border-b border-surface-100">
                        <h2 class="font-semibold text-surface-900">Фільтри</h2>
                        <button @click="mobileFiltersOpen = false" class="btn-icon">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                    <ProductFilters :filters-options="filtersOptions" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ProductGrid from '@/Components/Products/ProductGrid.vue';
import ProductFilters from '@/Components/Products/ProductFilters.vue';
import AppPagination from '@/Components/Products/AppPagination.vue';

const props = defineProps({
    products:       { type: Array, required: true },
    domain:         { type: String, default: '' },
    currentPage:    { type: Number, default: 1 },
    lastPage:       { type: Number, default: 1 },
    total:          { type: Number, default: 0 },
    perPage:        { type: Number, default: 12 },
    filtersOptions: { type: Object, required: true },
});

const filtersVisible = ref(true);
const mobileFiltersOpen = ref(false);

const toggleFilters = () => {
    if (window.innerWidth < 1024) {
        mobileFiltersOpen.value = !mobileFiltersOpen.value;
    } else {
        filtersVisible.value = !filtersVisible.value;
    }
};

const handlePageChange = (page) => {
    router.get(route('products.index'), { page }, { preserveState: true });
};
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
