<template>
    <nav class="flex items-center justify-center my-10 gap-4">
        <RouterLink
            class="text-gray-500 hover:text-gray-900 p-2 inline-flex items-center md:mr-8 mr-1"
            @click="goToPage(currentPage - 1)"
            :class="{'opacity-50 pointer-events-none': currentPage <= 1}"
            :to="`/products?page=${currentPage - 1}`"
        >
            <span class="w-10 h-10 rounded-full transition-all duration-150 flex justify-center items-center hover:border hover:border-indigo-600 hover:bg-indigo-50">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.5 1L1.91421 4.58578C1.24755 5.25245 0.914213 5.58579 0.914213 6C0.914213 6.41421 1.24755 6.74755 1.91421 7.41421L5.5 11" stroke="#4F46E5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </RouterLink>

        <RouterLink
            v-for="page in pageNumbers"
            :key="page"
            :to="`/products?page=${page}`"
            :class="['w-10 h-10 p-2 inline-flex items-center justify-center rounded-full transition-all duration-150', currentPage === page ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-500 hover:bg-indigo-50 hover:text-indigo-900']"
            @click="goToPage(page)"
        >
            {{ page }}
        </RouterLink>

        <RouterLink
            class="text-gray-500 hover:text-gray-900 p-2 inline-flex items-center md:ml-8 ml-1"
            @click="goToPage(currentPage + 1)"
            :class="{'opacity-50 pointer-events-none': currentPage >= lastPage}"
            :to="`/products?page=${currentPage + 1}`"
        >
            <span class="w-10 h-10 rounded-full transition-all duration-150 flex justify-center items-center hover:border hover:border-indigo-600 hover:bg-indigo-50">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.5 11L5.08578 7.41421C5.75245 6.74755 6.08579 6.41421 6.08579 6C6.08579 5.58579 5.75245 5.25245 5.08579 4.58579L1.5 1" stroke="#4F46E5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </RouterLink>
    </nav>
</template>

<script>
import { Link } from '@/services/spaCompat'
export default {
    name: "Pagination",
    props: {
        currentPage: {
            type: Number,
            required: true,
            default: 1,
        },
        lastPage: {
            type: Number,
            required: true,
            default: 1,
        },
        total: {
            type: Number,
            required: true,
            default: 0,
        },
        perPage: {
            type: Number,
            required: true,
            default: 10,
        },
    },

    components: {
        Link
    },
    computed: {
        pageNumbers() {
            const pages = [];
            for (let i = 1; i <= this.lastPage; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
    methods: {
        goToPage(page) {
            if (page > 0 && page <= this.lastPage) {
                this.$emit('page-changed', page);
            }
        },
    },
};
</script>
