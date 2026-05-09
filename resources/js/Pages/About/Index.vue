<template>
    <Head title="Про нас" />

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-[-1] bg-surface-50 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
    </div>

    <!-- Hero -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-surface-950 text-white min-h-[60vh] flex items-center rounded-b-[4rem] shadow-2xl z-10 mb-[-4rem]">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-br from-brand-600/30 to-indigo-600/30 rounded-full blur-[100px] pointer-events-none mix-blend-screen animate-pulse-slow"></div>
        </div>

        <div class="container-app relative z-10 text-center animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md mb-8 shadow-[0_0_20px_rgba(255,255,255,0.05)]">
                <span class="flex h-2.5 w-2.5 rounded-full bg-brand-400 shadow-[0_0_10px_#818cf8] animate-pulse"></span>
                <span class="text-sm font-bold uppercase tracking-widest text-white">Про TechStore</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight drop-shadow-md">
                Технології з <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-indigo-400 to-purple-400">людським</span> обличчям
            </h1>
            <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed font-medium">
                Ми створюємо простір, де інновації стають доступними, а процес вибору техніки — легким та приємним.
            </p>
        </div>
    </section>

    <!-- Stats -->
    <section class="pt-32 pb-16 relative z-20">
        <div class="container-app animate-slide-up-delayed">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <div v-for="stat in stats" :key="stat.label" class="card bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] text-center border border-white shadow-xl shadow-brand-500/5 hover:border-brand-200 hover:-translate-y-1 hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-300">
                    <p class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-brand-600 to-indigo-600 mb-2 drop-shadow-sm">{{ stat.value }}</p>
                    <p class="text-sm font-bold text-surface-600 uppercase tracking-wider">{{ stat.label }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story -->
    <section class="py-24">
        <div class="container-app">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-100/50 text-brand-700 font-bold uppercase tracking-wider text-xs mb-4 backdrop-blur-md border border-brand-200/50">
                        <i class="ri-history-line"></i> Наша історія
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-surface-900 tracking-tight mb-6">Більше ніж просто <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600">магазин</span></h2>
                    <p class="text-lg text-surface-600 leading-relaxed mb-6">
                        TechStore — це сучасний простір електроніки, що заснований у 2022 році групою ентузіастів. Ми спеціалізуємось
                        на продажу лише оригінальної техніки з офіційною гарантією.
                    </p>
                    <p class="text-lg text-surface-600 leading-relaxed mb-10">
                        Наша мета — зруйнувати стереотипи про складність вибору гаджетів. Ми робимо процес купівлі прозорим, зручним і швидким.
                    </p>

                    <div class="space-y-4">
                        <div v-for="point in highlights" :key="point" class="flex items-center gap-4 bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center flex-shrink-0 border border-brand-200">
                                <i class="ri-check-line text-brand-600 text-xl font-bold"></i>
                            </div>
                            <span class="text-base font-bold text-surface-800">{{ point }}</span>
                        </div>
                    </div>
                </div>

                <div class="relative animate-slide-up-delayed">
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden bg-surface-100 shadow-2xl relative border-8 border-white/50 backdrop-blur-sm">
                        <img
                            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2000"
                            alt="Команда TechStore"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-1000"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                    </div>
                    <!-- Decorative card -->
                    <div class="absolute -bottom-8 -left-8 card bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-2xl border border-white animate-float z-20">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white shadow-inner">
                                <i class="ri-shield-check-fill text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-brand-600 uppercase tracking-wider mb-0.5">Гарантія якості</p>
                                <p class="text-lg font-black text-surface-900">100% Оригінал</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-24 bg-surface-950 text-white relative overflow-hidden rounded-t-[4rem] shadow-[0_-20px_40px_rgba(0,0,0,0.1)]">
        <!-- Glow -->
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-brand-600/20 to-indigo-600/10 rounded-full blur-[120px] pointer-events-none animate-pulse-slow"></div>

        <div class="container-app relative z-10">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 text-white font-bold uppercase tracking-wider text-xs mb-4 backdrop-blur-md border border-white/20">
                    <i class="ri-star-smile-fill text-amber-400"></i> Філософія
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-4 drop-shadow-md">Наші цінності</h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto font-medium">Фундамент, на якому будується наша робота</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div v-for="value in values" :key="value.title" class="card bg-white/5 backdrop-blur-xl border border-white/10 p-8 md:p-10 rounded-[2.5rem] hover:bg-white/10 hover:border-brand-500/50 hover:-translate-y-2 transition-all duration-300 shadow-xl group">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 text-brand-400 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-brand-500 group-hover:text-white transition-all shadow-inner">
                        <i :class="value.icon" class="text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ value.title }}</h3>
                    <p class="text-white/70 leading-relaxed font-medium">{{ value.desc }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-br from-brand-600 via-indigo-600 to-purple-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_white,_transparent_70%)]"></div>
        <div class="container-app text-center max-w-3xl relative z-10">
            <h2 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight drop-shadow-lg">Готові до інновацій?</h2>
            <p class="text-xl text-white/90 mb-10 leading-relaxed font-medium">Перейдіть до каталогу та оберіть ідеальний пристрій, який допоможе вам досягати більшого.</p>
            <Link :href="route('products.index')" class="h-16 px-10 inline-flex items-center justify-center gap-3 rounded-2xl bg-white text-surface-950 font-black text-lg hover:bg-brand-50 hover:scale-105 transition-transform shadow-2xl group">
                <i class="ri-store-3-line text-brand-600 text-xl group-hover:animate-bounce"></i>
                Перейти до каталогу
            </Link>
        </div>
    </section>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

const stats = [
    { value: '100+', label: 'Успішних продаж' },
    { value: '125+', label: 'Унікальних товарів' },
    { value: '26+',  label: 'Нагород якості' },
    { value: '99%',  label: 'Задоволених клієнтів' },
];

const highlights = [
    'Офіційна гарантія на всі товари',
    'Доставка по всій Україні за 1-3 дні',
    'Підтримка 24/7 від наших фахівців',
    'Безпечна оплата через PayPal',
    'Просте повернення протягом 30 днів',
];

const values = [
    { icon: 'ri-heart-fill',        title: 'Турбота про клієнтів', desc: 'Кожен покупець для нас — це пріоритет. Ми робимо все можливе, щоб ваша покупка була приємною.' },
    { icon: 'ri-shield-check-fill', title: 'Якість та надійність',  desc: 'Ми ретельно відбираємо кожен товар, щоб гарантувати вам найвищу якість.' },
    { icon: 'ri-leaf-fill',         title: 'Відповідальність',       desc: 'Ми відповідально ставимось до нашої роботи, клієнтів і навколишнього середовища.' },
];
</script>

<style scoped>
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(12deg); }
    50%      { transform: translateY(-10px) rotate(12deg); }
}
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; }
    50%      { opacity: 0.6; }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.animate-float        { animation: float 4s ease-in-out infinite; }
.animate-pulse-slow   { animation: pulse-slow 6s ease-in-out infinite; }
.animate-pulse-slower { animation: pulse-slow 8s ease-in-out infinite; }
.animate-slide-up           { animation: slide-up 0.6s ease-out 0.1s both; }
.animate-slide-up-delayed   { animation: slide-up 0.6s ease-out 0.2s both; }

@media (prefers-reduced-motion: reduce) {
    .animate-float,
    .animate-pulse-slow,
    .animate-pulse-slower,
    .animate-slide-up,
    .animate-slide-up-delayed {
        animation: none;
    }
}
</style>
