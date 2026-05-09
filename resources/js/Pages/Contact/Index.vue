<template>
    <Head title="Контакти" />

    <!-- Hero -->
    <section class="bg-surface-950 py-24 text-center relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-brand-600/20 rounded-full blur-[100px] pointer-events-none mix-blend-screen"></div>
        </div>

        <div class="container-app relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-900 border border-surface-800 text-brand-400 mb-6 text-sm font-medium">
                <i class="ri-contacts-line"></i>
                На зв'язку 24/7
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">Зв'яжіться з нами</h1>
            <p class="text-lg text-surface-400 max-w-2xl mx-auto leading-relaxed">
                Ми завжди готові відповісти на ваші запитання, допомогти з вибором техніки або вирішити будь-які технічні проблеми.
            </p>
        </div>
    </section>

    <section class="py-20 bg-surface-50 relative z-20 -mt-10">
        <div class="container-app">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Contact info -->
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-surface-900 mb-8 tracking-tight">Наша контактна інформація</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                            v-for="info in contactInfo"
                            :key="info.label"
                            class="card bg-white p-6 rounded-2xl border border-surface-200 hover:border-brand-200 hover:shadow-md transition-all duration-300 group"
                        >
                            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                                <i :class="info.icon" class="text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-surface-500 mb-1 font-bold uppercase tracking-wider">{{ info.label }}</p>
                                <a :href="info.href" class="text-lg font-bold text-surface-900 hover:text-brand-600 transition-colors">
                                    {{ info.value }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Social -->
                    <div class="card bg-surface-900 p-8 rounded-3xl mt-8 text-white">
                        <h3 class="text-xl font-bold mb-2">Ми в соціальних мережах</h3>
                        <p class="text-surface-400 mb-6 text-sm">Слідкуйте за новинками, акціями та життям нашого магазину.</p>
                        <div class="flex gap-4">
                            <a v-for="s in socials" :key="s.label" :href="s.href" :aria-label="s.label"
                               class="w-12 h-12 rounded-2xl bg-surface-800 border border-surface-700 flex items-center justify-center text-surface-300 hover:bg-brand-600 hover:text-white hover:border-brand-600 hover:scale-110 transition-all duration-300 shadow-lg">
                                <i :class="s.icon" class="text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact form -->
                <div class="card bg-white p-8 md:p-10 rounded-3xl border border-surface-200 shadow-xl shadow-surface-200/50">
                    <h2 class="text-2xl font-bold text-surface-900 mb-2">Надіслати повідомлення</h2>
                    <p class="text-surface-500 mb-8">Заповніть форму нижче, і ми зв'яжемося з вами найближчим часом.</p>

                    <div v-if="sent" class="p-6 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 flex flex-col items-center text-center animate-fade-in">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mb-4">
                            <i class="ri-check-line text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Повідомлення успішно надіслано!</h3>
                        <p class="text-emerald-700/80">Дякуємо за звернення. Наш менеджер відповість вам протягом 24 годин.</p>
                        <button @click="sent = false; form.message = ''" class="mt-6 text-sm font-bold text-emerald-700 hover:text-emerald-900 underline">
                            Надіслати ще одне
                        </button>
                    </div>

                    <form v-else @submit.prevent="sendMessage" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact-name" class="block text-sm font-bold text-surface-900 mb-2">Ваше ім'я</label>
                                <div class="relative">
                                    <i class="ri-user-3-line absolute left-4 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="contact-name" v-model="form.name" type="text" placeholder="Іван Петренко" class="w-full h-12 pl-11 pr-4 rounded-xl border border-surface-200 bg-surface-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none" required />
                                </div>
                            </div>

                            <div>
                                <label for="contact-email" class="block text-sm font-bold text-surface-900 mb-2">Email</label>
                                <div class="relative">
                                    <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-surface-400"></i>
                                    <input id="contact-email" v-model="form.email" type="email" placeholder="your@email.com" class="w-full h-12 pl-11 pr-4 rounded-xl border border-surface-200 bg-surface-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none" required />
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="contact-message" class="block text-sm font-bold text-surface-900 mb-2">Повідомлення</label>
                            <textarea
                                id="contact-message"
                                v-model="form.message"
                                rows="5"
                                placeholder="Опишіть ваше запитання детально..."
                                class="w-full p-4 rounded-xl border border-surface-200 bg-surface-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none resize-none"
                                required
                            ></textarea>
                        </div>

                        <button type="submit" :disabled="sending" class="w-full h-14 rounded-xl bg-brand-600 text-white font-bold flex items-center justify-center gap-2 hover:bg-brand-700 transition-colors shadow-lg shadow-brand-500/20" id="contact-send-btn">
                            <i v-if="sending" class="ri-loader-4-line animate-spin"></i>
                            <i v-else class="ri-send-plane-fill"></i>
                            {{ sending ? 'Надсилаємо...' : 'Надіслати повідомлення' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue';

const sent = ref(false);
const sending = ref(false);

const form = reactive({ name: '', email: '', message: '' });

const sendMessage = () => {
    sending.value = true;
    // Simulate send (replace with actual axios call if you have an endpoint)
    setTimeout(() => {
        sending.value = false;
        sent.value = true;
    }, 1000);
};

const contactInfo = [
    { label: 'Телефон',  icon: 'ri-phone-line',    href: 'tel:+380706011911',          value: '+380-70-601-19-11' },
    { label: 'Email',    icon: 'ri-mail-line',      href: 'mailto:info@techstore.ua',   value: 'info@techstore.ua' },
    { label: 'Адреса',   icon: 'ri-map-pin-line',   href: '#',                          value: 'Кропивницький, вул. Шевченка, 25000' },
    { label: 'Графік',   icon: 'ri-time-line',      href: '#',                          value: 'Пн–Пт: 9:00–18:00, Сб–Нд: вихідний' },
];

const socials = [
    { label: 'Facebook', icon: 'ri-facebook-fill',  href: '#' },
    { label: 'Instagram', icon: 'ri-instagram-line', href: '#' },
    { label: 'Telegram', icon: 'ri-telegram-line',  href: '#' },
];
</script>
