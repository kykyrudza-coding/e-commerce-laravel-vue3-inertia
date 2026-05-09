<template>
    <Head title="Контакти" />

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-[-1] bg-surface-50 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
    </div>

    <!-- Hero -->
    <section class="bg-surface-950 py-24 text-center relative overflow-hidden rounded-b-[4rem] shadow-2xl z-10 mb-[-4rem]">
        <!-- Glows -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-gradient-to-br from-brand-600/30 to-indigo-600/30 rounded-full blur-[100px] pointer-events-none mix-blend-screen animate-pulse-slow"></div>
        </div>

        <div class="container-app relative z-10 animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md mb-6 shadow-[0_0_20px_rgba(255,255,255,0.05)]">
                <i class="ri-contacts-book-2-fill text-amber-400"></i>
                <span class="text-xs font-bold uppercase tracking-widest text-white">На зв'язку 24/7</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 tracking-tight drop-shadow-md">Зв'яжіться з нами</h1>
            <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto leading-relaxed font-medium">
                Ми завжди готові відповісти на ваші запитання, допомогти з вибором техніки або вирішити будь-які технічні проблеми.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="pt-32 pb-20 relative z-20">
        <div class="container-app">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto items-start">
                
                <!-- Contact info (Left) -->
                <div class="space-y-8 animate-slide-up-delayed">
                    <h2 class="text-3xl md:text-4xl font-black text-surface-900 tracking-tight drop-shadow-sm">Наша контактна інформація</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                            v-for="info in contactInfo"
                            :key="info.label"
                            class="card bg-white/70 backdrop-blur-xl p-6 rounded-[2rem] border border-white shadow-lg shadow-brand-500/5 hover:border-brand-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10 transition-all duration-300 group"
                        >
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm text-brand-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-brand-500 group-hover:to-indigo-600 group-hover:text-white transition-all duration-300">
                                <i :class="info.icon" class="text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500 mb-1 font-bold uppercase tracking-wider">{{ info.label }}</p>
                                <a :href="info.href" class="text-lg font-black text-surface-900 hover:text-brand-600 transition-colors">
                                    {{ info.value }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Social -->
                    <div class="card bg-surface-950 p-8 md:p-10 rounded-[2.5rem] relative overflow-hidden shadow-2xl text-white group mt-8">
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-600/20 to-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black mb-2 tracking-tight">Ми в соціальних мережах</h3>
                            <p class="text-white/70 mb-8 font-medium">Слідкуйте за новинками, акціями та життям нашого магазину.</p>
                            <div class="flex gap-4">
                                <a v-for="s in socials" :key="s.label" :href="s.href" :aria-label="s.label"
                                   class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center justify-center text-white hover:bg-white hover:text-brand-600 hover:border-white hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-300">
                                    <i :class="s.icon" class="text-3xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact form (Right) -->
                <div class="animate-slide-up-delayed">
                    <div class="card bg-white/80 backdrop-blur-2xl p-8 md:p-10 rounded-[2.5rem] border border-white shadow-2xl shadow-brand-500/10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-brand-100/50 to-transparent rounded-full blur-[60px] pointer-events-none -z-10"></div>
                        
                        <h2 class="text-3xl font-black text-surface-900 mb-2 tracking-tight">Надіслати повідомлення</h2>
                        <p class="text-surface-600 mb-8 font-medium">Заповніть форму нижче, і ми зв'яжемося з вами найближчим часом.</p>

                        <div v-if="sent" class="p-8 rounded-[2rem] bg-gradient-to-br from-emerald-50 to-emerald-100/50 border border-emerald-200 flex flex-col items-center text-center animate-fade-in shadow-inner">
                            <div class="w-20 h-20 rounded-3xl bg-emerald-500 shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white mb-6 animate-slide-up">
                                <i class="ri-check-double-line text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-emerald-900 mb-3 tracking-tight">Повідомлення успішно надіслано!</h3>
                            <p class="text-emerald-700 font-medium mb-8">Дякуємо за звернення. Наш менеджер відповість вам протягом 24 годин.</p>
                            <button @click="sent = false; form.message = ''" class="h-12 px-6 rounded-xl bg-white text-emerald-700 font-bold border border-emerald-200 hover:bg-emerald-50 hover:border-emerald-300 transition-all shadow-sm">
                                Надіслати ще одне
                            </button>
                        </div>

                        <form v-else @submit.prevent="sendMessage" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact-name" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Ваше ім'я</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="ri-user-smile-fill text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                                        </div>
                                        <input id="contact-name" v-model="form.name" type="text" placeholder="Іван Петренко" class="w-full h-14 pl-12 pr-4 rounded-2xl border border-surface-200 bg-white shadow-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all outline-none font-medium" required />
                                    </div>
                                </div>

                                <div>
                                    <label for="contact-email" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Email</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="ri-mail-send-fill text-surface-400 group-focus-within:text-brand-500 transition-colors"></i>
                                        </div>
                                        <input id="contact-email" v-model="form.email" type="email" placeholder="your@email.com" class="w-full h-14 pl-12 pr-4 rounded-2xl border border-surface-200 bg-white shadow-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all outline-none font-medium" required />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="contact-message" class="block text-sm font-bold text-surface-900 mb-2 ml-1">Повідомлення</label>
                                <div class="relative group">
                                    <textarea
                                        id="contact-message"
                                        v-model="form.message"
                                        rows="5"
                                        placeholder="Опишіть ваше запитання детально..."
                                        class="w-full p-4 rounded-2xl border border-surface-200 bg-white shadow-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all outline-none resize-none font-medium"
                                        required
                                    ></textarea>
                                </div>
                            </div>

                            <button type="submit" :disabled="sending" class="w-full h-16 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white font-black text-lg flex items-center justify-center gap-2 hover:from-brand-500 hover:to-indigo-500 transition-all shadow-xl shadow-brand-500/30 group disabled:opacity-70 disabled:cursor-not-allowed" id="contact-send-btn">
                                <i v-if="sending" class="ri-loader-4-line animate-spin text-2xl"></i>
                                <i v-else class="ri-send-plane-fill text-2xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                                <span>{{ sending ? 'Надсилаємо...' : 'Надіслати повідомлення' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head } from '@inertiajs/vue3';

const sent = ref(false);
const sending = ref(false);

const form = reactive({ name: '', email: '', message: '' });

const sendMessage = () => {
    sending.value = true;
    // Simulate send
    setTimeout(() => {
        sending.value = false;
        sent.value = true;
    }, 1000);
};

const contactInfo = [
    { label: 'Телефон',  icon: 'ri-phone-fill',    href: 'tel:+380706011911',          value: '+380-70-601-19-11' },
    { label: 'Email',    icon: 'ri-mail-fill',      href: 'mailto:info@techstore.ua',   value: 'info@techstore.ua' },
    { label: 'Адреса',   icon: 'ri-map-pin-fill',   href: '#',                          value: 'Кропивницький, вул. Шевченка' },
    { label: 'Графік',   icon: 'ri-time-fill',      href: '#',                          value: 'Пн–Пт: 9:00–18:00' },
];

const socials = [
    { label: 'Facebook', icon: 'ri-facebook-fill',  href: '#' },
    { label: 'Instagram', icon: 'ri-instagram-fill', href: '#' },
    { label: 'Telegram', icon: 'ri-telegram-fill',  href: '#' },
];
</script>

<style scoped>
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; }
    50%      { opacity: 0.6; }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.animate-pulse-slow   { animation: pulse-slow 6s ease-in-out infinite; }
.animate-pulse-slower { animation: pulse-slow 8s ease-in-out infinite; }
.animate-slide-up           { animation: slide-up 0.6s ease-out 0.1s both; }
.animate-slide-up-delayed   { animation: slide-up 0.6s ease-out 0.2s both; }

@media (prefers-reduced-motion: reduce) {
    .animate-pulse-slow,
    .animate-pulse-slower,
    .animate-slide-up,
    .animate-slide-up-delayed {
        animation: none;
    }
}
</style>
