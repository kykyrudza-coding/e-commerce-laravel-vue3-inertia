<template>
    <!-- Header -->
    <header
        class="sticky top-0 z-50 border-b border-surface-200 bg-white/80 backdrop-blur-md"
    >
        <div class="container-app">
            <div class="flex h-16 items-center justify-between gap-4">
                <!-- Left: Logo + Nav -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <Link :href="route('home')" class="flex items-center gap-2.5 group">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500 text-white shadow-sm group-hover:shadow-glow transition-shadow duration-300">
                            <i class="ri-store-2-line text-sm"></i>
                        </span>
                        <span class="text-base font-bold text-surface-900 tracking-tight hidden sm:block">TechStore</span>
                    </Link>

                    <!-- Desktop navigation -->
                    <nav class="hidden lg:flex items-center gap-1" aria-label="Головна навігація">
                        <Link
                            v-for="item in navItems"
                            :key="item.route"
                            :href="route(item.route)"
                            :class="['nav-link px-3 py-1.5 rounded-lg hover:bg-surface-50', isActive(item.route) && 'active text-surface-900 bg-surface-50']"
                        >
                            {{ item.label }}
                        </Link>
                    </nav>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2">
                    <!-- Search -->
                    <button
                        @click="search.toggle()"
                        class="btn-icon"
                        aria-label="Пошук"
                        id="header-search-btn"
                    >
                        <i class="ri-search-2-line text-lg"></i>
                    </button>

                    <!-- Cart (authenticated) -->
                    <Link
                        v-if="auth?.user"
                        :href="route('cart.index', auth.user.id)"
                        class="btn-icon relative"
                        aria-label="Кошик"
                        id="header-cart-btn"
                    >
                        <i class="ri-shopping-bag-3-line text-lg"></i>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white"
                        >
                            {{ cartCount > 9 ? '9+' : cartCount }}
                        </span>
                    </Link>

                    <!-- User menu -->
                    <template v-if="auth?.user">
                        <div class="relative" ref="userMenuRef">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl hover:bg-surface-50 transition-colors duration-200 group"
                                id="header-user-menu-btn"
                            >
                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-100 text-brand-700 text-xs font-semibold">
                                    {{ auth.user.name.charAt(0).toUpperCase() }}
                                </span>
                                <span class="hidden md:block text-sm font-medium text-surface-700 group-hover:text-surface-900">
                                    {{ auth.user.name }}
                                </span>
                                <i class="ri-arrow-down-s-line text-surface-400 text-sm transition-transform duration-200" :class="userMenuOpen && 'rotate-180'"></i>
                            </button>

                            <!-- Dropdown -->
                            <Transition name="dropdown">
                                <div
                                    v-if="userMenuOpen"
                                    class="absolute right-0 top-full mt-2 w-48 card py-1 z-10"
                                >
                                    <Link
                                        :href="route('profile.index', auth.user.id)"
                                        class="flex items-center gap-2.5 px-4 py-2 text-sm text-surface-700 hover:bg-surface-50 hover:text-surface-900"
                                        @click="userMenuOpen = false"
                                    >
                                        <i class="ri-user-line text-surface-400"></i>
                                        Профіль
                                    </Link>
                                    <div class="my-1 border-t border-surface-100"></div>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                        @click="userMenuOpen = false"
                                    >
                                        <i class="ri-logout-box-r-line"></i>
                                        Вийти
                                    </Link>
                                </div>
                            </Transition>
                        </div>
                    </template>

                    <!-- Guest auth buttons -->
                    <template v-else>
                        <Link :href="route('login')" class="btn-ghost btn-sm hidden sm:inline-flex" id="header-login-btn">
                            Увійти
                        </Link>
                        <Link :href="route('register')" class="btn-primary btn-sm" id="header-register-btn">
                            Реєстрація
                        </Link>
                    </template>

                    <!-- Mobile burger -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="btn-icon lg:hidden"
                        aria-label="Мобільне меню"
                        id="header-burger-btn"
                    >
                        <i :class="mobileMenuOpen ? 'ri-close-line' : 'ri-menu-2-line'" class="text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile navigation -->
        <Transition name="mobile-menu">
            <div v-if="mobileMenuOpen" class="lg:hidden border-t border-surface-200 bg-white">
                <nav class="container-app py-4 flex flex-col gap-1">
                    <Link
                        v-for="item in navItems"
                        :key="item.route"
                        :href="route(item.route)"
                        :class="['flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors duration-200', isActive(item.route) ? 'bg-brand-50 text-brand-700' : 'text-surface-600 hover:bg-surface-50 hover:text-surface-900']"
                        @click="mobileMenuOpen = false"
                    >
                        <i :class="item.icon" class="text-base"></i>
                        {{ item.label }}
                    </Link>

                    <div class="mt-3 pt-3 border-t border-surface-100 flex gap-2" v-if="!auth?.user">
                        <Link :href="route('login')" class="btn-secondary btn-sm flex-1 justify-center">Увійти</Link>
                        <Link :href="route('register')" class="btn-primary btn-sm flex-1 justify-center">Реєстрація</Link>
                    </div>
                </nav>
            </div>
        </Transition>
    </header>

    <!-- Search modal -->
    <SearchModal />
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useSearch } from '@/composables/useSearch.js';
import SearchModal from '@/Components/Search/SearchModal.vue';

const props = defineProps({
    auth: Object,
    cartCount: { type: Number, default: 0 },
});

const page = usePage();
const search = useSearch();

const mobileMenuOpen = ref(false);
const userMenuOpen = ref(false);
const userMenuRef = ref(null);

const navItems = [
    { label: 'Головна',   route: 'home',           icon: 'ri-home-3-line' },
    { label: 'Каталог',   route: 'products.index', icon: 'ri-store-3-line' },
    { label: 'Про нас',   route: 'about',           icon: 'ri-information-line' },
    { label: 'Контакти',  route: 'contact',         icon: 'ri-contacts-line' },
    { label: 'FAQ',       route: 'faq',             icon: 'ri-question-line' },
];

const isActive = (routeName) => {
    return page.url === route(routeName) || page.url.startsWith(route(routeName) + '/');
};

// Close user dropdown on outside click
const handleOutsideClick = (e) => {
    if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
        userMenuOpen.value = false;
    }
};

onMounted(() => document.addEventListener('click', handleOutsideClick));
onBeforeUnmount(() => document.removeEventListener('click', handleOutsideClick));
</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
    transition: opacity 0.15s ease, transform 0.15s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-4px) scale(0.98);
}

.mobile-menu-enter-active,
.mobile-menu-leave-active {
    transition: opacity 0.2s ease, max-height 0.3s ease;
    overflow: hidden;
    max-height: 400px;
}
.mobile-menu-enter-from,
.mobile-menu-leave-to {
    opacity: 0;
    max-height: 0;
}
</style>
