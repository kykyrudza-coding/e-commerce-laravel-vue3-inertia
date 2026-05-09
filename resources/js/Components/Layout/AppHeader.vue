<template>
    <!-- ═══════════════════════════════════════════════════════════
         TOP BAR — інформаційна стрічка над хедером
         ═══════════════════════════════════════════════════════════ -->
    <div class="relative bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 text-white text-xs overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.15),_transparent_60%)] pointer-events-none"></div>

        <div class="container-app relative z-10">
            <div class="flex h-9 items-center justify-between gap-4">
                <!-- Бігуча стрічка повідомлень -->
                <div class="flex-1 overflow-hidden">
                    <div class="flex items-center gap-8 whitespace-nowrap animate-marquee-slow">
                        <span
                            v-for="(msg, idx) in [...topBarMessages, ...topBarMessages]"
                            :key="idx"
                            class="flex items-center gap-2 font-medium"
                        >
                            <i :class="msg.icon" class="text-amber-300"></i>
                            {{ msg.text }}
                        </span>
                    </div>
                </div>

                <!-- Контакти праворуч (приховані на мобільному) -->
                <div class="hidden md:flex items-center gap-5 flex-shrink-0 font-medium">
                    <a href="tel:+380441234567" class="flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                        <i class="ri-phone-fill"></i>
                        +38 (044) 123-45-67
                    </a>
                    <span class="opacity-30">|</span>
                    <button class="flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                        <i class="ri-global-line"></i>
                        UA
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════
         HEADER — основний хедер
         ═══════════════════════════════════════════════════════════ -->
    <header
        :class="[
            'sticky top-0 z-40 transition-all duration-300',
            scrolled
                ? 'bg-white/90 backdrop-blur-xl shadow-lg shadow-brand-500/5 border-b border-white'
                : 'bg-white/80 backdrop-blur-md border-b border-surface-200/60'
        ]"
    >
        <!-- Декоративний фон -->
        <div class="absolute inset-0 bg-gradient-to-r from-brand-50/40 via-transparent to-indigo-50/40 pointer-events-none"></div>

        <div class="container-app relative">
            <div class="flex h-18 py-3 items-center justify-between gap-4">
                <!-- Ліва частина: лого + навігація -->
                <div class="flex items-center gap-8">
                    <!-- Лого з градієнтом -->
                    <Link :href="route('home')" class="flex items-center gap-3 group flex-shrink-0">
                        <span class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 via-indigo-500 to-purple-600 text-white shadow-lg shadow-brand-500/30 group-hover:shadow-xl group-hover:shadow-brand-500/40 group-hover:scale-105 transition-all duration-300">
                            <i class="ri-store-2-fill text-xl"></i>
                            <span class="absolute inset-0 rounded-2xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        </span>
                        <span class="text-xl font-black tracking-tight hidden sm:block">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600">Tech</span><span class="text-surface-900">Store</span>
                        </span>
                    </Link>

                    <!-- Десктоп навігація -->
                    <nav class="hidden lg:flex items-center gap-1" aria-label="Головна навігація">
                        <!-- Mega-menu кнопка "Каталог" -->
                        <div
                            class="relative"
                            @mouseenter="megaMenuOpen = true"
                            @mouseleave="megaMenuOpen = false"
                        >
                            <button
                                :class="[
                                    'flex items-center gap-1.5 px-4 py-2 rounded-xl font-semibold text-sm transition-all',
                                    megaMenuOpen
                                        ? 'bg-gradient-to-r from-brand-500 to-indigo-600 text-white shadow-md shadow-brand-500/30'
                                        : 'text-surface-700 hover:bg-surface-100'
                                ]"
                            >
                                <i class="ri-apps-2-line"></i>
                                Каталог
                                <i
                                    class="ri-arrow-down-s-line transition-transform duration-200"
                                    :class="megaMenuOpen && 'rotate-180'"
                                ></i>
                            </button>

                            <Transition name="mega">
                                <MegaMenu
                                    v-if="megaMenuOpen"
                                    :categories="categories"
                                    @close="megaMenuOpen = false"
                                />
                            </Transition>
                        </div>

                        <Link
                            v-for="item in navItems"
                            :key="item.route"
                            :href="route(item.route)"
                            :class="[
                                'flex items-center gap-1.5 px-4 py-2 rounded-xl font-semibold text-sm transition-all relative',
                                isActive(item.route)
                                    ? 'text-brand-600 bg-brand-50'
                                    : 'text-surface-700 hover:bg-surface-100'
                            ]"
                        >
                            {{ item.label }}
                            <span
                                v-if="isActive(item.route)"
                                class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-brand-500"
                            ></span>
                        </Link>
                    </nav>
                </div>

                <!-- Права частина: дії -->
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <!-- Пошук -->
                    <button
                        @click="search.toggle()"
                        class="flex items-center justify-center w-11 h-11 rounded-xl text-surface-600 hover:bg-surface-100 hover:text-brand-600 transition-all"
                        aria-label="Пошук"
                        id="header-search-btn"
                    >
                        <i class="ri-search-2-line text-xl"></i>
                    </button>

                    <!-- Вішлист -->
                    <Link
                        v-if="auth?.user"
                        :href="'#'"
                        class="hidden sm:flex relative items-center justify-center w-11 h-11 rounded-xl text-surface-600 hover:bg-pink-50 hover:text-pink-600 transition-all"
                        aria-label="Обране"
                    >
                        <i class="ri-heart-3-line text-xl"></i>
                        <span
                            v-if="wishlistCount > 0"
                            class="absolute top-1 right-1 flex h-4 min-w-[16px] px-1 items-center justify-center rounded-full bg-pink-500 text-[10px] font-bold text-white"
                        >
                            {{ wishlistCount > 9 ? '9+' : wishlistCount }}
                        </span>
                    </Link>

                    <!-- Кошик -->
                    <Link
                        v-if="auth?.user"
                        :href="route('cart.index', auth.user.id)"
                        class="relative flex items-center justify-center w-11 h-11 rounded-xl bg-gradient-to-br from-brand-500 to-indigo-600 text-white shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/40 hover:scale-105 transition-all"
                        aria-label="Кошик"
                        id="header-cart-btn"
                    >
                        <i class="ri-shopping-bag-3-fill text-lg"></i>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-1 -right-1 flex h-5 min-w-[20px] px-1 items-center justify-center rounded-full bg-amber-400 text-[11px] font-black text-amber-950 ring-2 ring-white animate-bounce-subtle"
                        >
                            {{ cartCount > 9 ? '9+' : cartCount }}
                        </span>
                    </Link>

                    <!-- Меню користувача -->
                    <template v-if="auth?.user">
                        <div class="relative" ref="userMenuRef">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-2 pl-1.5 pr-3 h-11 rounded-xl hover:bg-surface-100 transition-colors group"
                                id="header-user-menu-btn"
                            >
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-pink-500 to-rose-600 text-white text-sm font-bold shadow-sm">
                                    {{ auth.user.name.charAt(0).toUpperCase() }}
                                </span>
                                <span class="hidden md:block text-sm font-semibold text-surface-700 group-hover:text-surface-900 max-w-[100px] truncate">
                                    {{ auth.user.name }}
                                </span>
                                <i
                                    class="ri-arrow-down-s-line text-surface-400 text-base transition-transform"
                                    :class="userMenuOpen && 'rotate-180'"
                                ></i>
                            </button>

                            <Transition name="dropdown">
                                <div
                                    v-if="userMenuOpen"
                                    class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-surface-100 overflow-hidden z-50"
                                >
                                    <!-- Шапка дропдауна -->
                                    <div class="bg-gradient-to-br from-brand-500 to-indigo-600 p-4 text-white">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur text-white font-bold text-lg">
                                                {{ auth.user.name.charAt(0).toUpperCase() }}
                                            </span>
                                            <div class="min-w-0">
                                                <div class="font-bold truncate">{{ auth.user.name }}</div>
                                                <div class="text-xs text-white/80 truncate">{{ auth.user.email }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Пункти меню -->
                                    <div class="py-2">
                                        <Link
                                            :href="route('profile.index', auth.user.id)"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 hover:text-brand-600 transition-colors"
                                            @click="userMenuOpen = false"
                                        >
                                            <i class="ri-user-line text-lg"></i>
                                            Мій профіль
                                        </Link>
                                        <Link
                                            :href="'#'"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 hover:text-brand-600 transition-colors"
                                            @click="userMenuOpen = false"
                                        >
                                            <i class="ri-shopping-bag-line text-lg"></i>
                                            Мої замовлення
                                        </Link>
                                        <Link
                                            :href="'#'"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 hover:text-brand-600 transition-colors"
                                            @click="userMenuOpen = false"
                                        >
                                            <i class="ri-heart-3-line text-lg"></i>
                                            Обране
                                            <span v-if="wishlistCount > 0" class="ml-auto text-xs bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full font-bold">
                                                {{ wishlistCount }}
                                            </span>
                                        </Link>
                                    </div>

                                    <div class="border-t border-surface-100 py-2">
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                            @click="userMenuOpen = false"
                                        >
                                            <i class="ri-logout-box-r-line text-lg"></i>
                                            Вийти
                                        </Link>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </template>

                    <!-- Гостьові кнопки -->
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="hidden sm:inline-flex items-center h-11 px-4 rounded-xl text-sm font-bold text-surface-700 hover:bg-surface-100 transition-colors"
                            id="header-login-btn"
                        >
                            Увійти
                        </Link>
                        <Link
                            :href="route('register')"
                            class="inline-flex items-center h-11 px-5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-brand-500 to-indigo-600 shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/40 hover:scale-105 transition-all"
                            id="header-register-btn"
                        >
                            Реєстрація
                        </Link>
                    </template>

                    <!-- Бургер -->
                    <button
                        @click="mobileMenuOpen = true"
                        class="lg:hidden flex items-center justify-center w-11 h-11 rounded-xl text-surface-700 hover:bg-surface-100 transition-colors"
                        aria-label="Відкрити меню"
                        id="header-burger-btn"
                    >
                        <i class="ri-menu-2-line text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Мобільне меню -->
    <BurgerMenu
        :is-open="mobileMenuOpen"
        :auth="auth"
        :categories="categories"
        :nav-items="navItems"
        :is-active="isActive"
        @close="mobileMenuOpen = false"
    />

    <!-- Модалка пошуку -->
    <SearchModal />
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { useSearch } from '@/composables/useSearch.js'
import SearchModal from '@/Components/Search/SearchModal.vue'
import MegaMenu from '@/Components/Layout/MegaMenu.vue'
import BurgerMenu from '@/Components/Layout/BurgerMenu.vue'

const props = defineProps({
    auth:          { type: Object, default: () => ({}) },
    cartCount:     { type: Number, default: 0 },
    wishlistCount: { type: Number, default: 0 },
    categories:    { type: Array,  default: () => [] },
})

const page   = usePage()
const search = useSearch()

const mobileMenuOpen = ref(false)
const userMenuOpen   = ref(false)
const megaMenuOpen   = ref(false)
const userMenuRef    = ref(null)
const scrolled       = ref(false)

const topBarMessages = [
    { icon: 'ri-truck-fill',           text: 'Безкоштовна доставка від 1000 ₴' },
    { icon: 'ri-flashlight-fill',      text: 'Знижки до −50% на флагмани' },
    { icon: 'ri-shield-check-fill',    text: 'Офіційна гарантія до 36 місяців' },
    { icon: 'ri-customer-service-2-fill', text: 'Підтримка 24/7' },
]

const navItems = [
    { label: 'Головна',  route: 'home',    icon: 'ri-home-3-line' },
    { label: 'Про нас',  route: 'about',   icon: 'ri-information-line' },
    { label: 'Контакти', route: 'contact', icon: 'ri-contacts-line' },
    { label: 'FAQ',      route: 'faq',     icon: 'ri-question-line' },
]

const isActive = (routeName) => {
    try {
        const target = route(routeName)
        return page.url === target || page.url.startsWith(target + '/')
    } catch (e) {
        return false
    }
}

// Закриття дропдауна по кліку поза ним
const handleOutsideClick = (e) => {
    if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
        userMenuOpen.value = false
    }
}

// Зміна стилю хедера при скролі
const handleScroll = () => {
    scrolled.value = window.scrollY > 20
}

onMounted(() => {
    document.addEventListener('click', handleOutsideClick)
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleOutsideClick)
    window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
@keyframes marquee-slow {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-marquee-slow { animation: marquee-slow 35s linear infinite; }

@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-2px); }
}
.animate-bounce-subtle { animation: bounce-subtle 2s ease-in-out infinite; }

/* Dropdown transitions */
.dropdown-enter-active,
.dropdown-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-6px) scale(0.97);
}

/* Mega-menu transitions */
.mega-enter-active,
.mega-leave-active {
    transition: opacity 0.25s ease, transform 0.25s ease;
}
.mega-enter-from,
.mega-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}

/* Висота хедера */
.h-18 { height: 4.5rem; }

@media (prefers-reduced-motion: reduce) {
    .animate-marquee-slow,
    .animate-bounce-subtle {
        animation: none;
    }
}
</style>
