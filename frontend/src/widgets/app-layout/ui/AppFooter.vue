<template>
    <footer class="relative bg-gradient-to-br from-surface-950 via-brand-950 to-indigo-950 text-surface-200 mt-auto overflow-hidden">
        <!-- Декоративний фон -->
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-brand-500/15 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-500/15 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-[40%] left-[40%] w-[400px] h-[400px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- ═══════════════════════════════════════════════════════════
             NEWSLETTER — банер підписки
             ═══════════════════════════════════════════════════════════ -->
        <div class="relative z-10 container-app pt-16">
            <div class="rounded-[2.5rem] bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 p-8 md:p-12 shadow-2xl shadow-brand-500/20 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.2),_transparent_60%)]"></div>
                <i class="ri-mail-send-fill absolute -bottom-8 -right-8 text-[200px] text-white/10 rotate-[-15deg]"></i>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 mb-4">
                            <i class="ri-gift-fill text-amber-300"></i>
                            <span class="text-xs font-bold uppercase tracking-wider text-white">Бонус за підписку</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-white mb-2 leading-tight">
                            Знижка <span class="text-amber-300">10%</span> на перше замовлення
                        </h3>
                        <p class="text-white/80 text-sm md:text-base">
                            Підпишись і отримуй ексклюзивні пропозиції першим.
                        </p>
                    </div>

                    <form @submit.prevent="subscribeNewsletter" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="ri-mail-line absolute left-5 top-1/2 -translate-y-1/2 text-white/60 text-lg pointer-events-none"></i>
                            <input
                                v-model="newsletterEmail"
                                type="email"
                                required
                                placeholder="your@email.com"
                                class="w-full h-14 pl-12 pr-5 rounded-2xl bg-white/10 border border-white/20 backdrop-blur text-white placeholder-white/50 focus:outline-none focus:border-white/50 focus:bg-white/15 transition-all"
                            >
                        </div>
                        <button
                            type="submit"
                            :disabled="newsletterLoading"
                            class="h-14 px-8 bg-white text-surface-950 rounded-2xl font-bold hover:scale-105 transition-transform shadow-xl disabled:opacity-50 disabled:hover:scale-100 whitespace-nowrap"
                        >
                            {{ newsletterLoading ? 'Зачекайте...' : 'Підписатись' }}
                        </button>
                    </form>
                </div>
                <p v-if="newsletterMessage" class="relative z-10 text-sm text-emerald-200 mt-4 font-medium">
                    {{ newsletterMessage }}
                </p>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════
             ОСНОВНИЙ КОНТЕНТ ФУТЕРА
             ═══════════════════════════════════════════════════════════ -->
        <div class="relative z-10 container-app py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
                <!-- Бренд -->
                <div class="lg:col-span-4">
                    <RouterLink :to="route('home')" class="flex items-center gap-2.5 mb-6 w-fit group">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 via-indigo-500 to-purple-600 text-white shadow-lg shadow-brand-500/30 group-hover:shadow-xl group-hover:shadow-brand-500/50 transition-all">
                            <i class="ri-store-2-fill text-xl"></i>
                        </span>
                        <span class="text-2xl font-black tracking-tight">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-indigo-400">Tech</span><span class="text-white">Store</span>
                        </span>
                    </RouterLink>
                    <p class="text-sm text-surface-400 leading-relaxed max-w-md mb-6">
                        Сучасний інтернет-магазин електроніки. Найкращі ціни, блискавична доставка та професійна підтримка клієнтів 24/7.
                    </p>

                    <!-- Соцмережі -->
                    <div class="flex items-center gap-3 mb-8">
                        <a
                            v-for="social in socials"
                            :key="social.label"
                            :to="social.url"
                            class="relative w-11 h-11 rounded-2xl bg-white/5 border border-white/10 backdrop-blur flex items-center justify-center text-surface-300 hover:text-white hover:scale-110 transition-all overflow-hidden group"
                            :aria-label="social.label"
                        >
                            <span
                                class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity"
                                :class="social.bg"
                            ></span>
                            <i :class="social.icon" class="text-lg relative z-10"></i>
                        </a>
                    </div>

                    <!-- Бейджі довіри -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs text-surface-300 font-medium">
                            <i class="ri-shield-check-fill text-emerald-400"></i>
                            SSL захист
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs text-surface-300 font-medium">
                            <i class="ri-verified-badge-fill text-amber-400"></i>
                            Офіційний продавець
                        </span>
                    </div>
                </div>

                <!-- Навігація -->
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-black text-white uppercase tracking-wider mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 rounded-full bg-gradient-to-b from-brand-400 to-indigo-500"></span>
                        Магазин
                    </h4>
                    <ul class="space-y-3">
                        <li v-for="link in mainLinks" :key="link.route">
                            <RouterLink
                                :to="route(link.route)"
                                class="text-sm text-surface-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all"
                            >
                                {{ link.label }}
                            </RouterLink>
                        </li>
                    </ul>
                </div>

                <!-- Підтримка -->
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-black text-white uppercase tracking-wider mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 rounded-full bg-gradient-to-b from-pink-400 to-rose-500"></span>
                        Допомога
                    </h4>
                    <ul class="space-y-3">
                        <li v-for="link in helpLinks" :key="link.route">
                            <RouterLink
                                :to="route(link.route)"
                                class="text-sm text-surface-400 hover:text-pink-400 hover:translate-x-1 inline-block transition-all"
                            >
                                {{ link.label }}
                            </RouterLink>
                        </li>
                    </ul>
                </div>

                <!-- Контакти -->
                <div class="lg:col-span-4">
                    <h4 class="text-sm font-black text-white uppercase tracking-wider mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 rounded-full bg-gradient-to-b from-amber-400 to-orange-500"></span>
                        Контакти
                    </h4>
                    <div class="space-y-4">
                        <a
                            to="tel:+380441234567"
                            class="flex items-start gap-3 group"
                        >
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white group-hover:border-emerald-500 transition-all">
                                <i class="ri-phone-fill"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs text-surface-500 mb-0.5">Телефон</div>
                                <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">
                                    +38 (044) 123-45-67
                                </div>
                                <div class="text-xs text-surface-500">Пн-Нд: 9:00 — 21:00</div>
                            </div>
                        </a>

                        <a
                            to="mailto:hello@techstore.ua"
                            class="flex items-start gap-3 group"
                        >
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 group-hover:bg-amber-500 group-hover:text-white group-hover:border-amber-500 transition-all">
                                <i class="ri-mail-fill"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs text-surface-500 mb-0.5">Email</div>
                                <div class="text-sm font-bold text-white group-hover:text-amber-400 transition-colors break-all">
                                    hello@techstore.ua
                                </div>
                                <div class="text-xs text-surface-500">Відповідаємо за 1-2 години</div>
                            </div>
                        </a>

                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-500/10 border border-pink-500/20 text-pink-400">
                                <i class="ri-map-pin-fill"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs text-surface-500 mb-0.5">Адреса</div>
                                <div class="text-sm font-bold text-white">
                                    м. Київ, вул. Хрещатик, 22
                                </div>
                                <div class="text-xs text-surface-500">Шоурум та самовивіз</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════
             НИЖНЯ ПЛАШКА — копірайт + способи оплати
             ═══════════════════════════════════════════════════════════ -->
        <div class="relative z-10 border-t border-white/10">
            <div class="container-app py-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <!-- Копірайт -->
                    <p class="text-xs text-surface-500 text-center lg:text-left order-2 lg:order-1">
                        © {{ new Date().getFullYear() }} TechStore. Всі права захищені.
                        <span class="hidden sm:inline">·</span>
                        <RouterLink :to="'#'" class="hover:text-brand-400 transition-colors">Політика конфіденційності</RouterLink>
                        <span>·</span>
                        <RouterLink :to="'#'" class="hover:text-brand-400 transition-colors">Умови використання</RouterLink>
                    </p>

                    <!-- Методи оплати -->
                    <div class="flex items-center gap-3 order-1 lg:order-2">
                        <span class="text-xs font-medium text-surface-500 mr-1 hidden sm:inline">Ми приймаємо:</span>
                        <div class="flex items-center gap-2">
                            <span
                                v-for="method in paymentMethods"
                                :key="method.label"
                                class="flex items-center justify-center h-9 px-3 rounded-lg bg-white/5 border border-white/10 backdrop-blur text-surface-300 hover:text-white hover:bg-white/10 transition-colors"
                                :title="method.label"
                            >
                                <i v-if="method.icon" :class="method.icon" class="text-lg mr-1.5"></i>
                                <span class="text-xs font-bold">{{ method.label }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue'

const mainLinks = [
    { label: 'Головна',         route: 'home' },
    { label: 'Каталог',         route: 'products.index' },
    { label: 'Про нас',         route: 'about' },
    { label: 'Акції',           route: 'products.index' },
    { label: 'Новинки',         route: 'products.index' },
]

const helpLinks = [
    { label: 'Контакти',        route: 'contact' },
    { label: 'FAQ',             route: 'faq' },
    { label: 'Доставка',        route: 'faq' },
    { label: 'Повернення',      route: 'faq' },
    { label: 'Гарантія',        route: 'faq' },
]

const socials = [
    { label: 'Facebook',  icon: 'ri-facebook-circle-fill', url: '#', bg: 'bg-blue-600' },
    { label: 'Instagram', icon: 'ri-instagram-line',       url: '#', bg: 'bg-gradient-to-br from-pink-500 via-rose-500 to-amber-500' },
    { label: 'Telegram',  icon: 'ri-telegram-fill',        url: '#', bg: 'bg-sky-500' },
    { label: 'YouTube',   icon: 'ri-youtube-fill',         url: '#', bg: 'bg-red-600' },
    { label: 'TikTok',    icon: 'ri-tiktok-fill',          url: '#', bg: 'bg-surface-900' },
]

const paymentMethods = [
    { label: 'Visa',      icon: 'ri-visa-fill' },
    { label: 'MasterCard', icon: 'ri-mastercard-fill' },
    { label: 'Apple Pay', icon: 'ri-apple-fill' },
    { label: 'Google Pay', icon: 'ri-google-fill' },
    { label: 'Privat24',  icon: null },
]

// Newsletter
const newsletterEmail   = ref('')
const newsletterLoading = ref(false)
const newsletterMessage = ref('')

const subscribeNewsletter = async () => {
    newsletterLoading.value = true
    // TODO: підключити API client post(route('newsletter.subscribe'), { email })
    setTimeout(() => {
        newsletterLoading.value = false
        newsletterMessage.value = '✓ Підписка оформлена! Перевір пошту.'
        newsletterEmail.value   = ''
    }, 800)
}
</script>
