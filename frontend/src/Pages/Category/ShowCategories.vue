<template>
    <Head :title="category.name" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-6">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">{{ category.name }}</span>
        </nav>

        <h1 class="page-title mb-2">{{ category.name }}</h1>
        <p class="page-subtitle mb-8">{{ products.length || 0 }} товарів у категорії</p>

        <!-- Subcategory chips -->
        <div v-if="category.all_children?.length" class="flex flex-wrap gap-2 mb-8">
            <RouterLink
                v-for="child in category.all_children"
                :key="child.id"
                :to="route('categories.show.subcategory', { subcategory_slug: child.slug })"
                class="btn-secondary btn-sm"
                :id="`category-chip-${child.slug}`"
            >
                {{ child.name }}
            </RouterLink>
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
            @page-changed="fetchCategory"
        />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '@/services/api';
import ProductGrid from '@/Components/Products/ProductGrid.vue';
import AppPagination from '@/Components/Products/AppPagination.vue';

const props = defineProps({
    id:          { type: [String, Number], default: null },
    category:    { type: Object, default: () => ({}) },
    products:    { type: [Array, Object], default: () => [] },
    currentPage: { type: Number, default: 1 },
    lastPage:    { type: Number, default: 1 },
    total:       { type: Number, default: 0 },
    perPage:     { type: Number, default: 12 },
    domain:      { type: String, default: '' },
});

const routeParams = useRoute();
const category = ref(props.category);
const products = ref(Array.isArray(props.products) ? props.products : Object.values(props.products));
const currentPage = ref(props.currentPage);
const lastPage = ref(props.lastPage);
const total = ref(props.total);
const perPage = ref(props.perPage);
const domain = ref(props.domain || import.meta.env.VITE_API_ORIGIN || 'http://localhost');

const fetchCategory = async (page = 1) => {
    const id = props.id || routeParams.params.id;
    const response = await api.get(`/categories/${id}/products`, { params: { page } });
    category.value = response.data.category?.data || response.data.category || {};
    products.value = response.data.data;
    currentPage.value = response.data.meta?.current_page ?? page;
    lastPage.value = response.data.meta?.last_page ?? 1;
    total.value = response.data.meta?.total ?? products.value.length;
    perPage.value = response.data.meta?.per_page ?? 15;
};

onMounted(() => fetchCategory());
</script>
