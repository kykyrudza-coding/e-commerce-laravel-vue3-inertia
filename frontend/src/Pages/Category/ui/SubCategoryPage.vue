<template>
    <Head :title="category.name" />

    <div class="container-app py-8">
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">{{ category.name }}</span>
        </nav>

        <h1 class="page-title mb-2">{{ category.name }}</h1>
        <p class="page-subtitle mb-8">{{ Array.isArray(products) ? products.length : 0 }} товарів</p>

        <ProductGrid :products="Array.isArray(products) ? products : Object.values(products)" :domain="domain" />

        <AppPagination
            v-if="lastPage > 1"
            :current-page="currentPage"
            :last-page="lastPage"
            :total="total"
            :per-page="perPage"
            @page-changed="(p) => router.get(window.location.pathname, { page: p })"
        />
    </div>
</template>

<script setup>
import { router } from '@/shared/lib/spa-compat';
import { ProductGrid } from '@/widgets/product-catalog';
import { AppPagination } from '@/features/products/paginate-products';

defineProps({
    category:    { type: Object, required: true },
    products:    { type: [Array, Object], default: () => [] },
    currentPage: { type: Number, default: 1 },
    lastPage:    { type: Number, default: 1 },
    total:       { type: Number, default: 0 },
    perPage:     { type: Number, default: 12 },
    domain:      { type: String, default: '' },
});
</script>
