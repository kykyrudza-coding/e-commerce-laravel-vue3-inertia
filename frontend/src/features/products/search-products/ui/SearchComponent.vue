<template>
    <i class="ri-search-2-line cursor-pointer text-2xl" @click="toggleSearchModal"></i>

    <transition
        name="fade"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
    >
        <div
            v-if="isSearchModalVisible"
            class="fixed inset-0 flex justify-center items-center z-50 bg-black bg-opacity-50"
            @click.self="closeSearchModal"
        >
            <div class="relative bg-white p-6 rounded-lg w-full max-w-4xl">
                <input
                    type="text"
                    v-model="searchQuery"
                    placeholder="Пошук по назві чи опису..."
                    @input="debouncedSearch"
                    class="w-96 p-3 border border-gray-300 rounded mb-4"
                    ref="searchInput"
                />

                <button @click="closeSearchModal" class="absolute top-2 right-2 text-2xl text-gray-500 hover:text-red-500">
                    <i class="ri-close-line"></i>
                </button>

                <div v-if="loading" class="text-center text-gray-500">
                    Завантаження...
                </div>

                <div v-if="searchResults.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                    <div
                        v-for="(result, index) in searchResults"
                        :key="result.id"
                        class="p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow"
                    >
                        <RouterLink :to="route('products.show', result.slug)">
                            <h3 class="font-semibold mb-2">
                                {{ result.name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ truncateDescription(result.description) }}
                            </p>
                        </RouterLink>
                    </div>
                </div>

                <p v-else-if="!loading && searchQuery" class="text-center text-gray-500">
                    Ничего не найдено
                </p>
            </div>
        </div>
    </transition>
</template>

<script>
import debounce from "lodash/debounce";
import api, { apiData } from '@/shared/api';

export default {
    name: "SearchComponent",
        data() {
        return {
            isSearchModalVisible: false,
            searchQuery: "",
            searchResults: [],
            loading: false,
        };
    },
    methods: {
        toggleSearchModal() {
            this.isSearchModalVisible = !this.isSearchModalVisible;
            if (this.isSearchModalVisible) {
                document.body.style.overflow = 'hidden';
                this.$nextTick(() => this.$refs.searchInput.focus());
            } else {
                document.body.style.overflow = '';
            }
        },
        closeSearchModal() {
            this.isSearchModalVisible = false;
            this.searchQuery = "";
            this.searchResults = [];
            document.body.style.overflow = '';
        },
        beforeEnter(el) {
            el.style.opacity = 0;
        },
        enter(el, done) {
            el.offsetHeight;
            el.style.transition = "opacity 0.2s ease-in-out";
            el.style.opacity = 1;
            done();
        },
        leave(el, done) {
            el.style.transition = "opacity 0.1s ease-in-out";
            el.style.opacity = 0;
            done();
        },
        async search() {
            if (!this.searchQuery) {
                this.searchResults = [];
                return;
            }

            this.loading = true;

            try {
                const response = await api.get('/search', { params: { query: this.searchQuery } });
                this.searchResults = apiData(response, []);
            } catch (error) {
                console.error('Помилка пошуку:', error);
            } finally {
                this.loading = false;
            }
        },
        debouncedSearch: debounce(function () {
            this.search();
        }, 300),
        truncateDescription(description, length = 100) {
            if (description.length > length) {
                return description.substring(0, length) + '...';
            }
            return description;
        }
    },
    mounted() {
        window.addEventListener('keydown', this.handleKeyPress);
    },
    beforeUnmount() {
        window.removeEventListener('keydown', this.handleKeyPress);
    }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s ease-in-out;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

input[type="text"] {
    transition: width 0.3s ease;
}

input[type="text"]:focus {
    width: 90%;
}

.grid > div {
    display: flex;
    flex-direction: column;
}

.grid > div h3 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.grid > div p {
    font-size: 0.875rem;
    color: #6b7280;
}
</style>
