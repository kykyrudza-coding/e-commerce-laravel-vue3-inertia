<template>
    <Head title="FAQ" />

    <!-- Hero -->
    <section class="bg-surface-950 py-24 text-center relative overflow-hidden">
        <!-- Glows -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-brand-600/20 rounded-full blur-[100px] pointer-events-none mix-blend-screen"></div>
        </div>

        <div class="container-app relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-900 border border-surface-800 text-brand-400 mb-6 text-sm font-medium">
                <i class="ri-question-answer-line"></i>
                Допомога
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">Часті запитання</h1>
            <p class="text-lg text-surface-400 max-w-2xl mx-auto leading-relaxed">
                Ми зібрали відповіді на найпопулярніші питання наших клієнтів, щоб ви могли швидко знайти потрібну інформацію.
            </p>
        </div>
    </section>

    <!-- FAQ list -->
    <section class="py-20 bg-surface-50">
        <div class="container-app">
            <div class="max-w-3xl mx-auto space-y-4 relative z-10 -mt-32">
                <div
                    v-for="(faq, idx) in faqs"
                    :key="idx"
                    class="card bg-white rounded-2xl border border-surface-200 overflow-hidden shadow-lg shadow-surface-200/50 hover:border-brand-200 transition-colors"
                >
                    <button
                        @click="toggleFaq(idx)"
                        class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-surface-50/50 transition-colors duration-200 group focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                        :id="`faq-item-${idx}`"
                    >
                        <span class="font-bold text-lg text-surface-900 pr-4 group-hover:text-brand-600 transition-colors">{{ faq.question }}</span>
                        <div class="w-8 h-8 rounded-full bg-surface-100 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                            <i
                                :class="['ri-arrow-down-s-line text-xl transition-transform duration-300 ease-spring', openFaqs.has(idx) && 'rotate-180']"
                            ></i>
                        </div>
                    </button>

                    <Transition name="faq-answer">
                        <div v-if="openFaqs.has(idx)" class="px-6 pb-6">
                            <p class="text-base text-surface-600 leading-relaxed border-t border-surface-100 pt-5 mt-2">
                                {{ faq.answer }}
                            </p>
                        </div>
                    </Transition>
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="mt-24 text-center max-w-2xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-6">
                    <i class="ri-customer-service-2-line text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-surface-900 mb-4">Не знайшли потрібної відповіді?</h3>
                <p class="text-surface-500 mb-8 text-lg">Наша служба підтримки працює цілодобово та готова допомогти з будь-яким питанням.</p>
                <Link :href="route('contact')" class="h-14 px-8 inline-flex items-center justify-center gap-2 rounded-full bg-brand-600 text-white font-bold hover:bg-brand-700 transition-colors shadow-lg shadow-brand-500/30" id="faq-contact-btn">
                    Зв'язатися з нами
                    <i class="ri-arrow-right-line"></i>
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue';

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
    transition: opacity 0.2s ease, max-height 0.3s ease;
    overflow: hidden;
    max-height: 300px;
}
.faq-answer-enter-from, .faq-answer-leave-to {
    opacity: 0;
    max-height: 0;
}
</style>
