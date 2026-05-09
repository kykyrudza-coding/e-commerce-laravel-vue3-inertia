<template>
    <Head :title="category.name" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <Link :href="route('home')" class="hover:text-surface-600 transition-colors">Головна</Link>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">{{ category.name }}</span>
        </nav>

        <h1 class="page-title mb-2">{{ category.name }}</h1>
        <p class="page-subtitle mb-8">{{ products.length || 0 }} товарів у категорії</p>

        <!-- Subcategory chips -->
        <div v-if="category.all_children?.length" class="flex flex-wrap gap-2 mb-8">
            <Link
                v-for="child in category.all_children"
                :key="child.id"
                :href="route('categories.show.subcategory', { subcategory_slug: child.slug })"
                class="btn-secondary btn-sm"
                :id="`category-chip-${child.slug}`"
            >
                {{ child.name }}
            </Link>
        </div>

        <!-- Products -->
        <ProductGrid :products="products" :domain="domain" />

        <!-- Pagination -->
        <AppPagination
            v-if="lastPage > 1"
            :current-page="currentPage"
            :last-page="lastPage"
            :total="total"
            :per-page="perPage"
            @page-changed="(p) => router.get(route('categories.show', category.slug), { page: p })"
        />
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import ProductGrid from '@/Components/Products/ProductGrid.vue';
import AppPagination from '@/Components/Products/AppPagination.vue';

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
