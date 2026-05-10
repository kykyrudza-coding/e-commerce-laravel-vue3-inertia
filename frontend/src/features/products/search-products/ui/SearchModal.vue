<template>
    <Teleport to="body">
        <Transition name="modal">
            <div
                v-if="search.isSearchOpen.value"
                class="fixed inset-0 z-[60] flex items-start justify-center pt-16 px-4"
                @click.self="search.close()"
            >
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-surface-950/50 backdrop-blur-sm"></div>

                <!-- Modal -->
                <div class="relative w-full max-w-2xl animate-slide-up">
                    <div class="card overflow-hidden">
                        <!-- Input -->
                        <div class="flex items-center gap-3 px-4 py-3 border-b border-surface-100">
                            <i class="ri-search-2-line text-xl text-surface-400 flex-shrink-0"></i>
                            <input
                                ref="inputRef"
                                v-model="search.query.value"
                                type="text"
                                placeholder="Пошук товарів..."
                                class="flex-1 text-base bg-transparent text-surface-900 placeholder-surface-400 outline-none"
                                @input="search.search()"
                                @keydown.escape="search.close()"
                                id="search-modal-input"
                            />
                            <kbd class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-surface-100 text-surface-400 text-xs font-mono">
                                Esc
                            </kbd>
                            <button @click="search.close()" class="btn-icon">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>

                        <!-- Results -->
                        <div class="max-h-[420px] overflow-y-auto">
                            <!-- Loading -->
                            <div v-if="search.loading.value" class="p-6 flex items-center justify-center gap-3 text-surface-500">
                                <i class="ri-loader-4-line animate-spin text-xl text-brand-500"></i>
                                <span class="text-sm">Пошук...</span>
                            </div>

                            <!-- Results list -->
                            <div v-else-if="search.results.value.length > 0" class="divide-y divide-surface-100">
                                <RouterLink
                                    v-for="result in search.results.value"
                                    :key="result.id"
                                    :to="route('products.show', result.slug)"
                                    @click="search.close()"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-surface-50 transition-colors duration-150 group"
                                >
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-surface-100 flex items-center justify-center">
                                        <i class="ri-box-3-line text-surface-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-surface-900 truncate group-hover:text-brand-600">
                                            {{ result.name }}
                                        </p>
                                        <p class="text-xs text-surface-400 truncate">
                                            {{ truncate(result.description) }}
                                        </p>
                                    </div>
                                    <i class="ri-arrow-right-s-line text-surface-300 group-hover:text-brand-500 flex-shrink-0"></i>
                                </RouterLink>
                            </div>

                            <!-- Empty -->
                            <div v-else-if="search.query.value && !search.loading.value" class="p-8 text-center">
                                <i class="ri-search-line text-4xl text-surface-200 mb-3 block"></i>
                                <p class="text-surface-500 text-sm">Нічого не знайдено для "<strong>{{ search.query.value }}</strong>"</p>
                            </div>

                            <!-- Initial hint -->
                            <div v-else class="p-6 text-center text-surface-400 text-sm">
                                <i class="ri-keyboard-line text-2xl mb-2 block text-surface-200"></i>
                                Почніть вводити для пошуку
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue';
import { useSearch } from '../model/useSearch.js';
import { truncate } from '@/shared/lib';

const search = useSearch();
const inputRef = ref(null);

// Focus input when modal opens
watch(() => search.isSearchOpen.value, async (val) => {
    if (val) {
        await nextTick();
        inputRef.value?.focus();
    }
});
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.2s ease;
}
.modal-enter-from, .modal-leave-to {
    opacity: 0;
}
</style>
