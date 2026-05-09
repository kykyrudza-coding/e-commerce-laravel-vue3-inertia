<template>
    <footer class="bg-surface-950 text-surface-200 mt-auto border-t border-surface-900">
        <div class="container-app py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <Link :href="route('home')" class="flex items-center gap-2.5 mb-6 w-fit group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-indigo-600 text-white shadow-lg shadow-brand-500/20 group-hover:shadow-brand-500/40 transition-all duration-300">
                            <i class="ri-store-2-line text-lg"></i>
                        </span>
                        <span class="text-xl font-bold text-white tracking-tight">TechStore</span>
                    </Link>
                    <p class="text-sm text-surface-400 leading-relaxed max-w-sm mb-8">
                        Сучасний інтернет-магазин електроніки. Найкращі ціни, блискавична доставка та професійна підтримка клієнтів 24/7.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-surface-900 border border-surface-800 flex items-center justify-center text-surface-400 hover:bg-brand-500 hover:text-white hover:border-brand-500 transition-all duration-300" aria-label="Facebook">
                            <i class="ri-facebook-circle-fill text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-surface-900 border border-surface-800 flex items-center justify-center text-surface-400 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-all duration-300" aria-label="Instagram">
                            <i class="ri-instagram-line text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-surface-900 border border-surface-800 flex items-center justify-center text-surface-400 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition-all duration-300" aria-label="Telegram">
                            <i class="ri-telegram-fill text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-6">Навігація</h4>
                    <ul class="space-y-3">
                        <li v-for="link in mainLinks" :key="link.route">
                            <Link
                                :href="route(link.route)"
                                class="text-sm text-surface-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-6">Підтримка</h4>
                    <ul class="space-y-3">
                        <li v-for="link in helpLinks" :key="link.route">
                            <Link
                                :href="route(link.route)"
                                class="text-sm text-surface-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="mt-16 pt-8 border-t border-surface-800/50 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-surface-500">
                    © {{ new Date().getFullYear() }} TechStore. Всі права захищені.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-6">
                    <span class="text-xs font-medium text-surface-400 flex items-center gap-1.5">
                        <i class="ri-shield-check-fill text-brand-400 text-base"></i>
                        Безпечна оплата
                    </span>
                    <span class="text-xs font-medium text-surface-400 flex items-center gap-1.5">
                        <i class="ri-truck-fill text-brand-400 text-base"></i>
                        Швидка доставка
                    </span>
                    <span class="text-xs font-medium text-surface-400 flex items-center gap-1.5">
                        <i class="ri-customer-service-2-fill text-brand-400 text-base"></i>
                        Підтримка 24/7
                    </span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
const mainLinks = [
    { label: 'Головна',  route: 'home' },
    { label: 'Каталог',  route: 'products.index' },
    { label: 'Про нас',  route: 'about' },
];

const helpLinks = [
    { label: 'Контакти', route: 'contact' },
    { label: 'FAQ',      route: 'faq' },
];
</script>
