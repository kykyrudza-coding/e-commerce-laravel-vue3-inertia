<template>
    <Head title="FAQ" />

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
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-gradient-to-br from-brand-600/30 to-indigo-600/30 rounded-full blur-[100px] pointer-events-none mix-blend-screen animate-pulse-slow"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
        </div>

        <div class="container-app relative z-10 animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md mb-6 shadow-[0_0_20px_rgba(255,255,255,0.05)]">
                <i class="ri-question-answer-fill text-amber-400"></i>
                <span class="text-xs font-bold uppercase tracking-widest text-white">Допомога</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 tracking-tight drop-shadow-md">Часті запитання</h1>
            <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto leading-relaxed font-medium">
                Ми зібрали відповіді на найпопулярніші питання наших клієнтів, щоб ви могли швидко знайти потрібну інформацію.
            </p>
        </div>
    </section>

    <!-- FAQ list -->
    <section class="pt-32 pb-20 relative z-20">
        <div class="container-app">
            <div class="max-w-3xl mx-auto space-y-4 animate-slide-up-delayed">
                <div
                    v-for="(faq, idx) in faqs"
                    :key="idx"
                    class="card bg-white/70 backdrop-blur-xl rounded-[2rem] border border-white overflow-hidden shadow-xl shadow-brand-500/5 hover:border-brand-200 transition-all duration-300"
                >
                    <button
                        @click="toggleFaq(idx)"
                        class="w-full flex items-center justify-between px-6 py-6 text-left hover:bg-white/50 transition-colors duration-200 group focus:outline-none"
                        :id="`faq-item-${idx}`"
                    >
                        <span class="font-bold text-lg md:text-xl text-surface-900 pr-4 group-hover:text-brand-600 transition-colors">{{ faq.question }}</span>
                        <div class="w-10 h-10 rounded-2xl bg-white shadow-sm flex items-center justify-center flex-shrink-0 group-hover:bg-brand-500 group-hover:text-white transition-all">
                            <i
                                :class="['ri-arrow-down-s-line text-2xl transition-transform duration-300 ease-spring', openFaqs.has(idx) && 'rotate-180']"
                            ></i>
                        </div>
                    </button>

                    <Transition name="faq-answer">
                        <div v-if="openFaqs.has(idx)" class="px-6 pb-6">
                            <p class="text-base md:text-lg text-surface-600 leading-relaxed border-t border-surface-200/50 pt-5 mt-2 font-medium">
                                {{ faq.answer }}
                            </p>
                        </div>
                    </Transition>
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="mt-24 text-center max-w-2xl mx-auto animate-slide-up-delayed relative">
                <!-- Decorative element -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-[400px] bg-brand-400/10 rounded-full blur-[80px] pointer-events-none -z-10"></div>
                
                <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-brand-500 to-indigo-600 text-white flex items-center justify-center mx-auto mb-8 shadow-xl shadow-brand-500/20 hover:scale-110 transition-transform">
                    <i class="ri-customer-service-2-fill text-4xl"></i>
                </div>
                <h3 class="text-3xl font-black text-surface-900 mb-4 tracking-tight">Не знайшли потрібної відповіді?</h3>
                <p class="text-surface-600 mb-10 text-lg font-medium">Наша служба підтримки працює цілодобово та готова допомогти з будь-яким питанням.</p>
                <RouterLink :to="route('contact')" class="h-16 px-10 inline-flex items-center justify-center gap-3 rounded-2xl bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 hover:-translate-y-1 transition-all shadow-xl shadow-brand-500/30 group" id="faq-contact-btn">
                    Зв'язатися з нами
                    <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                </RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Head, Link } from '@/services/spaCompat';

const openFaqs = reactive(new Set([0])); // first item open by default

const toggleFaq = (idx) => {
    if (openFaqs.has(idx)) {
        openFaqs.delete(idx);
    } else {
        openFaqs.add(idx);
    }
};

const faqs = [
    {
        question: 'Як оновити платіжні дані?',
        answer: 'Перейдіть у розділ "Мій профіль" на сайті та внесіть необхідні зміни в розділі "Платіжна інформація". Всі зміни набудуть чинності після збереження.',
    },
    {
        question: 'Як зв\'язатися зі службою підтримки?',
        answer: 'Ви можете зв\'язатися з нами через форму на сторінці "Контакти", або зателефонувати за номером +380-70-601-19-11. Підтримка доступна 24/7.',
    },
    {
        question: 'Як оновити інформацію профілю?',
        answer: 'Перейдіть у "Профіль" → "Редагувати профіль" та внесіть необхідні зміни. Не забудьте натиснути "Зберегти зміни".',
    },
    {
        question: 'Який термін доставки?',
        answer: 'Стандартна доставка по Україні займає 1-3 робочі дні. Після відправлення замовлення ви отримаєте трек-номер на email.',
    },
    {
        question: 'Чи можна повернути товар?',
        answer: 'Так, ми приймаємо повернення протягом 30 днів з моменту отримання замовлення. Товар має бути в оригінальній упаковці та без слідів використання.',
    },
    {
        question: 'Які способи оплати доступні?',
        answer: 'Ми приймаємо оплату через PayPal. Всі транзакції захищені сучасними технологіями шифрування.',
    },
];
</script>

<style scoped>
.faq-answer-enter-active, .faq-answer-leave-active {
    transition: opacity 0.3s ease, max-height 0.4s ease;
    overflow: hidden;
    max-height: 400px;
}
.faq-answer-enter-from, .faq-answer-leave-to {
    opacity: 0;
    max-height: 0;
}

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
