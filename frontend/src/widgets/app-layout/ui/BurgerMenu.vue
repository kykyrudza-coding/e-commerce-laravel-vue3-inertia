<template>
    <Teleport to="body">
        <Transition name="burger">
            <div
                v-if="isOpen"
                class="fixed inset-0 z-[60] lg:hidden"
                @keydown.esc="$emit('close')"
            >
                <!-- Затемнення -->
                <div
                    class="absolute inset-0 bg-surface-950/60 backdrop-blur-sm"
                    @click="$emit('close')"
                ></div>

                <!-- Панель -->
                <aside
                    class="absolute right-0 top-0 bottom-0 w-[88%] max-w-md bg-white shadow-2xl flex flex-col overflow-hidden burger-panel"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Мобільне меню"
                >
                    <!-- Декоративний фон -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-200/40 rounded-full blur-[80px] pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-200/40 rounded-full blur-[80px] pointer-events-none"></div>

                    <!-- Хедер панелі -->
                    <div class="relative z-10 flex items-center justify-between p-5 border-b border-surface-100">
                        <RouterLink
                            :to="route('home')"
                            class="flex items-center gap-2.5"
                            @click="$emit('close')"
                        >
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 via-indigo-500 to-purple-600 text-white shadow-lg shadow-brand-500/30">
                                <i class="ri-store-2-fill text-lg"></i>
                            </span>
                            <span class="text-lg font-black tracking-tight">
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600">Tech</span><span class="text-surface-900">Store</span>
                            </span>
                        </RouterLink>

                        <button
                            @click="$emit('close')"
                            class="flex items-center justify-center w-10 h-10 rounded-xl text-surface-600 hover:bg-surface-100 transition-colors"
                            aria-label="Закрити меню"
                        >
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <!-- Профіль користувача -->
                    <div v-if="auth?.user" class="relative z-10 p-5 border-b border-surface-100">
                        <RouterLink
                            :to="route('profile.index', auth.user.id)"
                            class="flex items-center gap-3 p-4 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 text-white shadow-lg shadow-brand-500/20"
                            @click="$emit('close')"
                        >
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur text-white font-bold text-lg flex-shrink-0">
                                {{ auth.user.name.charAt(0).toUpperCase() }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold truncate">{{ auth.user.name }}</div>
                                <div class="text-xs text-white/80 truncate">{{ auth.user.email }}</div>
                            </div>
                            <i class="ri-arrow-right-s-line text-xl flex-shrink-0"></i>
                        </RouterLink>
                    </div>

                    <!-- Контент меню (скрол) -->
                    <div class="relative z-10 flex-1 overflow-y-auto">
                        <!-- Основна навігація -->
                        <nav class="p-5 flex flex-col gap-1.5" aria-label="Основна навігація">
                            <RouterLink
                                v-for="item in navItems"
                                :key="item.route"
                                :to="route(item.route)"
                                :class="[
                                    'flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-colors',
                                    isActive(item.route)
                                        ? 'bg-gradient-to-r from-brand-500 to-indigo-600 text-white shadow-md shadow-brand-500/30'
                                        : 'text-surface-700 hover:bg-surface-50'
                                ]"
                                @click="$emit('close')"
                            >
                                <i :class="item.icon" class="text-xl"></i>
                                {{ item.label }}
                                <i v-if="isActive(item.route)" class="ri-arrow-right-s-line ml-auto"></i>
                            </RouterLink>
                        </nav>

                        <!-- Категорії -->
                        <div v-if="categories?.length" class="px-5 pb-5">
                            <div class="text-xs font-bold uppercase tracking-wider text-surface-500 mb-3 px-4">
                                Каталог
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <RouterLink
                                    v-for="(category, idx) in categories.slice(0, 8)"
                                    :key="category.id"
                                    :to="route('categories.show', category.slug)"
                                    class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-surface-100 hover:border-brand-200 hover:bg-brand-50/50 transition-all group"
                                    @click="$emit('close')"
                                >
                                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-surface-100 to-surface-50 group-hover:from-brand-500 group-hover:to-indigo-600 text-surface-600 group-hover:text-white transition-all">
                                        <i :class="getCategoryIcon(idx)" class="text-2xl"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-surface-700 text-center leading-tight">
                                        {{ category.name }}
                                    </span>
                                </RouterLink>
                            </div>
                        </div>

                        <!-- Швидкі контакти -->
                        <div class="px-5 pb-5">
                            <div class="text-xs font-bold uppercase tracking-wider text-surface-500 mb-3 px-4">
                                Зв'язок
                            </div>
                            <a
                                to="tel:+380441234567"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-surface-700 hover:bg-surface-50 transition-colors"
                            >
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                    <i class="ri-phone-fill text-lg"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="text-xs text-surface-500">Телефон</div>
                                    <div class="font-bold text-sm">+38 (044) 123-45-67</div>
                                </div>
                            </a>
                            <a
                                to="mailto:hello@techstore.ua"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-surface-700 hover:bg-surface-50 transition-colors"
                            >
                                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                    <i class="ri-mail-fill text-lg"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="text-xs text-surface-500">Email</div>
                                    <div class="font-bold text-sm">hello@techstore.ua</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Футер панелі -->
                    <div class="relative z-10 p-5 border-t border-surface-100 bg-white">
                        <!-- Гостьові кнопки -->
                        <div v-if="!auth?.user" class="flex flex-col gap-2">
                            <RouterLink
                                :to="route('register')"
                                class="flex items-center justify-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-brand-500 to-indigo-600 shadow-md shadow-brand-500/20"
                                @click="$emit('close')"
                            >
                                Реєстрація
                            </RouterLink>
                            <RouterLink
                                :to="route('login')"
                                class="flex items-center justify-center h-12 px-4 rounded-xl text-sm font-bold text-surface-700 bg-surface-100 hover:bg-surface-200 transition-colors"
                                @click="$emit('close')"
                            >
                                Увійти
                            </RouterLink>
                        </div>

                        <!-- Кнопка виходу -->
                        <button
                            v-else
                            type="button"
                            class="flex w-full items-center justify-center gap-2 h-12 px-4 rounded-xl text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors"
                            @click="handleLogout"
                        >
                            <i class="ri-logout-box-r-line text-lg"></i>
                            Вийти
                        </button>
                    </div>
                </aside>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { watch } from 'vue'
import { useRouter } from 'vue-router'
import api, { clearAuthToken } from '@/shared/api'
import { usePage } from '@/shared/lib/spa-compat'

const props = defineProps({
    isOpen:     { type: Boolean, required: true },
    auth:       { type: Object,  default: () => ({}) },
    categories: { type: Array,   default: () => [] },
    navItems:   { type: Array,   required: true },
    isActive:   { type: Function, required: true },
})
const emit = defineEmits(['close'])
const router = useRouter()
const page = usePage()

const categoryIcons = [
    'ri-macbook-line', 'ri-smartphone-line', 'ri-headphone-line', 'ri-gamepad-line',
    'ri-camera-3-line', 'ri-tv-2-line', 'ri-watch-line', 'ri-plug-line',
]
const getCategoryIcon = (idx) => categoryIcons[idx] || 'ri-shopping-bag-line'

const handleLogout = async () => {
    try {
        await api.post('/logout')
    } finally {
        clearAuthToken()
        page.props.auth.user = null
        emit('close')
        router.push(route('home'))
    }
}

// Блокуємо скрол body, коли меню відкрите
watch(() => props.isOpen, (open) => {
    if (typeof document !== 'undefined') {
        document.body.style.overflow = open ? 'hidden' : ''
    }
})
</script>

<style scoped>
.burger-enter-active,
.burger-leave-active {
    transition: opacity 0.3s ease;
}
.burger-enter-from,
.burger-leave-to {
    opacity: 0;
}

.burger-enter-active .burger-panel,
.burger-leave-active .burger-panel {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.burger-enter-from .burger-panel,
.burger-leave-to .burger-panel {
    transform: translateX(100%);
}

@media (prefers-reduced-motion: reduce) {
    .burger-enter-active,
    .burger-leave-active,
    .burger-enter-active .burger-panel,
    .burger-leave-active .burger-panel {
        transition: none;
    }
}
</style>
