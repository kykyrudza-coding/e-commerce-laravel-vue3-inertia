<template>
    <div
        class="absolute left-0 top-full pt-3 w-screen max-w-5xl"
    >
        <div class="bg-white rounded-3xl shadow-2xl border border-surface-100 overflow-hidden">
            <div class="grid grid-cols-12 min-h-[420px]">
                <!-- Ліва частина: список категорій -->
                <div class="col-span-4 bg-gradient-to-br from-surface-50 to-brand-50/50 p-6 border-r border-surface-100">
                    <div class="text-xs font-bold uppercase tracking-wider text-surface-500 mb-4 px-3">
                        Категорії
                    </div>
                    <div class="flex flex-col gap-1">
                        <button
                            v-for="(category, idx) in displayCategories"
                            :key="category.id"
                            @mouseenter="hoveredIndex = idx"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-all"
                            :class="hoveredIndex === idx
                                ? 'bg-white shadow-md text-brand-600'
                                : 'text-surface-700 hover:bg-white/60'"
                        >
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-lg transition-all flex-shrink-0"
                                :class="hoveredIndex === idx
                                    ? 'bg-gradient-to-br from-brand-500 to-indigo-600 text-white shadow-md'
                                    : 'bg-white text-surface-500'"
                            >
                                <i :class="getCategoryIcon(idx)" class="text-lg"></i>
                            </span>
                            <span class="font-semibold text-sm flex-1 truncate">{{ category.name }}</span>
                            <i
                                class="ri-arrow-right-s-line transition-all"
                                :class="hoveredIndex === idx ? 'text-brand-500 translate-x-0.5' : 'text-surface-400'"
                            ></i>
                        </button>
                    </div>
                </div>

                <!-- Права частина: підкатегорії та промо -->
                <div class="col-span-8 p-8 relative">
                    <!-- Декоративний фон -->
                    <div class="absolute top-0 right-0 w-80 h-80 bg-brand-100/30 rounded-full blur-[80px] pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <div class="text-xs font-bold uppercase tracking-wider text-brand-600 mb-1">
                                    {{ activeCategory?.name }}
                                </div>
                                <h3 class="text-xl font-black text-surface-900">
                                    Перегляньте найкраще
                                </h3>
                            </div>
                            <RouterLink
                                v-if="activeCategory?.slug"
                                :to="route('categories.show', activeCategory.slug)"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold text-brand-600 hover:bg-brand-50 transition-colors"
                                @click="$emit('close')"
                            >
                                Всі товари
                                <i class="ri-arrow-right-line"></i>
                            </RouterLink>
                        </div>

                        <!-- Швидкі посилання (плейсхолдер — підкатегорії) -->
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <RouterLink
                                v-for="quick in quickLinks"
                                :key="quick.label"
                                :to="route('products.index')"
                                class="group flex items-center gap-3 p-3 rounded-2xl border border-surface-100 hover:border-brand-200 hover:bg-brand-50/50 transition-all"
                                @click="$emit('close')"
                            >
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-50 group-hover:bg-white text-brand-600 transition-colors">
                                    <i :class="quick.icon" class="text-lg"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-surface-900 truncate group-hover:text-brand-600 transition-colors">
                                        {{ quick.label }}
                                    </div>
                                    <div class="text-xs text-surface-500 truncate">{{ quick.hint }}</div>
                                </div>
                            </RouterLink>
                        </div>

                        <!-- Промо-блок -->
                        <RouterLink
                            :to="route('products.index')"
                            class="block relative rounded-2xl overflow-hidden bg-gradient-to-br from-brand-600 via-indigo-600 to-purple-600 p-6 group"
                            @click="$emit('close')"
                        >
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.2),_transparent_60%)]"></div>
                            <i class="ri-flashlight-fill absolute -bottom-4 -right-4 text-[120px] text-white/15 group-hover:rotate-12 transition-transform duration-500"></i>

                            <div class="relative z-10 flex items-center justify-between gap-4">
                                <div>
                                    <span class="inline-block px-2.5 py-1 bg-amber-400 text-amber-950 rounded-md text-xs font-black uppercase tracking-wider mb-2">
                                        −30%
                                    </span>
                                    <h4 class="text-xl font-black text-white mb-1">Сезонний розпродаж</h4>
                                    <p class="text-white/80 text-sm">Сотні товарів зі знижками до 50%</p>
                                </div>
                                <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white text-brand-600 shadow-lg group-hover:translate-x-1 transition-transform">
                                    <i class="ri-arrow-right-line text-xl"></i>
                                </span>
                            </div>
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    categories: { type: Array, default: () => [] },
})
defineEmits(['close'])

const hoveredIndex = ref(0)

const displayCategories = computed(() => props.categories.slice(0, 8))
const activeCategory    = computed(() => displayCategories.value[hoveredIndex.value])

const categoryIcons = [
    'ri-macbook-line',
    'ri-smartphone-line',
    'ri-headphone-line',
    'ri-gamepad-line',
    'ri-camera-3-line',
    'ri-tv-2-line',
    'ri-watch-line',
    'ri-plug-line',
]
const getCategoryIcon = (idx) => categoryIcons[idx] || 'ri-shopping-bag-line'

// Швидкі посилання (можна замінити на реальні підкатегорії)
const quickLinks = [
    { label: 'Новинки',      icon: 'ri-sparkling-2-line', hint: 'Свіжі надходження' },
    { label: 'Хіти продажів', icon: 'ri-fire-line',        hint: 'Топ цього місяця' },
    { label: 'Зі знижкою',   icon: 'ri-price-tag-3-line', hint: 'Економія до 50%' },
]
</script>
