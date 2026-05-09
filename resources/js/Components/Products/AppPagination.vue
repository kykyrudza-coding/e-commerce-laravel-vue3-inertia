<template>
    <div class="flex items-center justify-center gap-2 mt-8 py-4">
        <!-- Prev -->
        <button
            @click="emit('page-changed', currentPage - 1)"
            :disabled="currentPage <= 1"
            class="btn-secondary btn-sm disabled:opacity-40"
            id="pagination-prev"
        >
            <i class="ri-arrow-left-s-line"></i>
            <span class="hidden sm:inline">Назад</span>
        </button>

        <!-- Pages -->
        <div class="flex items-center gap-1">
            <template v-for="page in visiblePages" :key="page">
                <span v-if="page === '...'" class="px-2 text-surface-400 text-sm">…</span>
                <button
                    v-else
                    @click="emit('page-changed', page)"
                    :class="[
                        'w-9 h-9 rounded-xl text-sm font-medium transition-all duration-200',
                        page === currentPage
                            ? 'bg-brand-500 text-white shadow-sm'
                            : 'text-surface-600 hover:bg-surface-100 hover:text-surface-900'
                    ]"
                    :id="`pagination-page-${page}`"
                >
                    {{ page }}
                </button>
            </template>
        </div>

        <!-- Next -->
        <button
            @click="emit('page-changed', currentPage + 1)"
            :disabled="currentPage >= lastPage"
            class="btn-secondary btn-sm disabled:opacity-40"
            id="pagination-next"
        >
            <span class="hidden sm:inline">Вперед</span>
            <i class="ri-arrow-right-s-line"></i>
        </button>
    </div>

    <!-- Info -->
    <p class="text-center text-xs text-surface-400 mt-2">
        Сторінка {{ currentPage }} з {{ lastPage }} · {{ total }} товарів
    </p>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    currentPage: { type: Number, required: true },
    lastPage:    { type: Number, required: true },
    total:       { type: Number, default: 0 },
    perPage:     { type: Number, default: 12 },
});

const emit = defineEmits(['page-changed']);

const visiblePages = computed(() => {
    const pages = [];
    const delta = 2;
    const range = [];

    for (let i = Math.max(2, props.currentPage - delta); i <= Math.min(props.lastPage - 1, props.currentPage + delta); i++) {
        range.push(i);
    }

    if (props.currentPage - delta > 2) range.unshift('...');
    if (props.currentPage + delta < props.lastPage - 1) range.push('...');

    range.unshift(1);
    if (props.lastPage > 1) range.push(props.lastPage);

    return range;
});
</script>
