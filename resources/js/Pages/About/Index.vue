<template>
    <Head title="Про нас" />

    <!-- Hero -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-surface-950 text-white min-h-[60vh] flex items-center">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-600/20 rounded-full blur-[100px] pointer-events-none mix-blend-screen"></div>
        </div>

        <div class="container-app relative z-10 text-center animate-fade-in">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-900/50 border border-white/10 backdrop-blur-md mb-8">
                <span class="flex h-2 w-2 rounded-full bg-brand-500 animate-pulse"></span>
                <span class="text-sm font-medium text-surface-200">Про TechStore</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight">
                Технології з <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-indigo-400">людським</span> обличчям
            </h1>
            <p class="text-surface-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                Ми створюємо простір, де інновації стають доступними, а процес вибору техніки — легким та приємним.
            </p>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-surface-50 to-transparent z-10"></div>
    </section>

    <!-- Stats -->
    <section class="py-16 bg-surface-50 relative z-20 -mt-10">
        <div class="container-app">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <div v-for="stat in stats" :key="stat.label" class="card bg-white p-8 rounded-3xl text-center border border-surface-200 shadow-sm hover:border-brand-200 hover:shadow-md transition-all duration-300">
                    <p class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-surface-900 to-surface-600 mb-2">{{ stat.value }}</p>
                    <p class="text-sm font-medium text-surface-500 uppercase tracking-wider">{{ stat.label }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story -->
    <section class="py-24 bg-white">
        <div class="container-app">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-5xl font-bold text-surface-900 tracking-tight mb-6">Більше ніж просто <span class="text-brand-600">магазин</span></h2>
                    <p class="text-lg text-surface-600 leading-relaxed mb-6">
                        TechStore — це сучасний простір електроніки, що заснований у 2022 році групою ентузіастів. Ми спеціалізуємось
                        на продажу лише оригінальної техніки з офіційною гарантією.
                    </p>
                    <p class="text-lg text-surface-600 leading-relaxed mb-10">
                        Наша мета — зруйнувати стереотипи про складність вибору гаджетів. Ми робимо процес купівлі прозорим, зручним і швидким.
                    </p>

                    <div class="space-y-4">
                        <div v-for="point in highlights" :key="point" class="flex items-center gap-4 bg-surface-50 p-4 rounded-2xl border border-surface-100">
                            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center flex-shrink-0">
                                <i class="ri-check-line text-brand-600 text-lg"></i>
                            </div>
                            <span class="text-base font-medium text-surface-800">{{ point }}</span>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-[4/5] rounded-[2.5rem] overflow-hidden bg-surface-100 shadow-2xl relative">
                        <img
                            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2000"
                            alt="Команда TechStore"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                    <!-- Decorative card -->
                    <div class="absolute -bottom-8 -left-8 card bg-white p-6 rounded-3xl shadow-xl shadow-surface-200/50 border border-surface-100 animate-float">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center text-white shadow-inner">
                                <i class="ri-shield-check-fill text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-brand-600 uppercase tracking-wider mb-0.5">Гарантія якості</p>
                                <p class="text-base font-bold text-surface-900">100% Оригінал</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-24 bg-surface-950 text-white relative overflow-hidden">
        <!-- Glow -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-600/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container-app relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight mb-4">Наші цінності</h2>
                <p class="text-surface-400 text-lg max-w-2xl mx-auto">Фундамент, на якому будується наша робота</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div v-for="value in values" :key="value.title" class="card bg-surface-900 border border-surface-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group">
                    <div class="w-14 h-14 rounded-2xl bg-surface-800 text-brand-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i :class="value.icon" class="text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ value.title }}</h3>
                    <p class="text-surface-400 leading-relaxed">{{ value.desc }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-brand-50">
        <div class="container-app text-center max-w-3xl">
            <h2 class="text-4xl md:text-5xl font-bold text-surface-900 mb-6 tracking-tight">Розпочніть свій шлях з нами</h2>
            <p class="text-lg text-surface-600 mb-10 leading-relaxed">Перейдіть до каталогу та оберіть ідеальний пристрій, який допоможе вам досягати більшого.</p>
            <Link :href="route('products.index')" class="h-16 px-10 inline-flex items-center justify-center gap-3 rounded-full bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 hover:scale-105 transition-all shadow-xl shadow-brand-500/30">
                <i class="ri-store-3-line"></i>
                Перейти до каталогу
            </Link>
        </div>
    </section>
</template>

<script setup>
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
    { icon: 'ri-heart-line',        title: 'Турбота про клієнтів', desc: 'Кожен покупець для нас — це пріоритет. Ми робимо все можливе, щоб ваша покупка була приємною.' },
    { icon: 'ri-shield-check-line', title: 'Якість та надійність',  desc: 'Ми ретельно відбираємо кожен товар, щоб гарантувати вам найвищу якість.' },
    { icon: 'ri-leaf-line',         title: 'Відповідальність',       desc: 'Ми відповідально ставимось до нашої роботи, клієнтів і навколишнього середовища.' },
];
</script>
