<template>
    <Head title="Головна" />

    <!-- ═══════════════════════════════════════════════════════════
         AMBIENT BACKGROUND (для всієї сторінки)
         ═══════════════════════════════════════════════════════════ -->
    <div class="fixed inset-0 z-[-1] bg-surface-50 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
        <div class="absolute top-[60%] left-[30%] w-[40%] h-[40%] bg-pink-400/10 rounded-full blur-[120px] mix-blend-multiply"></div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════
         HERO CAROUSEL (автослайдер з 4 слайдами)
         ═══════════════════════════════════════════════════════════ -->
    <section class="container-app py-8 mt-4">
        <div
            class="relative w-full rounded-[2.5rem] overflow-hidden shadow-2xl shadow-brand-500/10 group bg-surface-950"
            @mouseenter="pauseSlider"
            @mouseleave="resumeSlider"
        >
            <!-- Слайди -->
            <div class="relative min-h-[400px] md:min-h-[480px]">
                <transition-group name="slide-fade">
                    <div
                        v-for="(slide, idx) in heroSlides"
                        v-show="idx === activeSlide"
                        :key="slide.id"
                        class="absolute inset-0"
                    >
                        <!-- Анімований фон слайда -->
                        <div
                            class="absolute inset-0 transition-all duration-1000"
                            :class="slide.bgClass"
                        ></div>
                        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-white/30 to-transparent rounded-full blur-[80px] pointer-events-none"></div>

                        <div class="relative grid grid-cols-1 lg:grid-cols-2 min-h-[400px] md:min-h-[480px]">
                            <!-- Контент -->
                            <div class="relative z-10 flex flex-col justify-center lg:justify-start p-8 md:p-14 lg:p-16">
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md w-fit mb-6 animate-slide-down">
                                    <i :class="slide.badgeIcon" class="text-amber-400"></i>
                                    <span class="text-xs font-bold uppercase tracking-widest text-white">{{ slide.badge }}</span>
                                </div>

                                <h1
                                    class="min-h-[5.4rem] sm:min-h-[6.2rem] md:min-h-[7.2rem] lg:min-h-[8rem] xl:min-h-[8.6rem] max-w-[34rem] font-black text-white leading-[1.1] mb-4 tracking-tight drop-shadow-md animate-slide-up"
                                    :class="slide.titleClass ?? 'text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl'"
                                >
                                    {{ slide.titleLine1 }}<br>
                                    <span class="block text-transparent bg-clip-text break-words" :class="slide.titleAccent">{{ slide.titleLine2 }}</span>
                                </h1>

                                <p class="min-h-[4.5rem] text-white/80 text-base sm:text-lg mb-8 max-w-md font-medium animate-slide-up-delayed">
                                    {{ slide.description }}
                                </p>

                                <div class="flex flex-wrap items-center gap-4 animate-slide-up-delayed-2">
                                    <RouterLink :to="slide.ctaLink" class="relative inline-flex items-center justify-center h-14 px-8 text-base font-bold text-surface-950 bg-white rounded-2xl overflow-hidden group/btn hover:scale-105 transition-all shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                                        <span class="relative z-10 flex items-center gap-2">
                                            {{ slide.ctaText }}
                                            <i class="ri-arrow-right-line text-lg group-hover/btn:translate-x-1 transition-transform"></i>
                                        </span>
                                    </RouterLink>
                                    <span class="text-white font-bold text-xl ml-2">{{ slide.price }}</span>
                                </div>
                            </div>

                            <!-- Зображення -->
                            <div class="relative hidden lg:flex items-center justify-center p-10">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white/10 to-transparent"></div>
                                <div class="relative w-full h-full flex items-center justify-center">
                                    <img
                                        :src="slide.image"
                                        :alt="slide.titleLine1"
                                        class="relative z-10 object-cover w-[80%] h-[80%] rounded-3xl shadow-2xl rotate-[-5deg] hover:rotate-0 transition-all duration-[1s] border border-white/10 animate-float-slow"
                                        loading="lazy"
                                    >
                                    <div class="absolute top-10 right-10 w-20 h-20 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl rotate-12 z-20 shadow-xl flex items-center justify-center animate-float">
                                        <i :class="slide.floatIcon" class="text-4xl text-white/50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>

            <!-- Стрілки керування -->
            <button
                @click="prevSlide"
                aria-label="Попередній слайд"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-white hover:text-surface-950 transition-all"
            >
                <i class="ri-arrow-left-s-line text-2xl"></i>
            </button>
            <button
                @click="nextSlide"
                aria-label="Наступний слайд"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-white hover:text-surface-950 transition-all"
            >
                <i class="ri-arrow-right-s-line text-2xl"></i>
            </button>

            <!-- Індикатори -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-30">
                <button
                    v-for="(slide, idx) in heroSlides"
                    :key="`indicator-${slide.id}`"
                    @click="goToSlide(idx)"
                    :aria-label="`Перейти до слайду ${idx + 1}`"
                    class="h-1.5 rounded-full transition-all"
                    :class="idx === activeSlide
                        ? 'w-8 bg-white shadow-[0_0_10px_rgba(255,255,255,0.5)]'
                        : 'w-2 bg-white/30 hover:bg-white/50'"
                ></button>
            </div>

            <!-- Прогрес-бар автоплею -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/10 z-30">
                <div
                    class="h-full bg-white/60 transition-all duration-100 ease-linear"
                    :style="{ width: `${slideProgress}%` }"
                ></div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         FLASH SALE COUNTDOWN (зворотний відлік)
         ═══════════════════════════════════════════════════════════ -->
    <section class="container-app py-6">
        <div class="relative rounded-[2rem] overflow-hidden bg-gradient-to-r from-red-600 via-pink-600 to-orange-500 p-6 md:p-8 shadow-xl shadow-red-500/20">
            <!-- Декоративні елементи -->
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,_white,_transparent_60%)]"></div>
            <i class="ri-flashlight-fill absolute -bottom-8 -left-8 text-[180px] text-white/10 rotate-[-15deg]"></i>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white shadow-lg flex-shrink-0">
                        <i class="ri-flashlight-fill text-3xl animate-pulse"></i>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold uppercase tracking-wider mb-2">Тільки сьогодні</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white drop-shadow">Знижки до 50% на флагмани</h3>
                    </div>
                </div>

                <!-- Countdown -->
                <div class="flex items-center gap-2 md:gap-3">
                    <div
                        v-for="unit in countdownUnits"
                        :key="unit.label"
                        class="flex flex-col items-center"
                    >
                        <div class="relative w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/95 backdrop-blur-md flex items-center justify-center shadow-xl">
                            <span class="text-2xl md:text-4xl font-black text-surface-900 tabular-nums">
                                {{ String(unit.value).padStart(2, '0') }}
                            </span>
                        </div>
                        <span class="text-xs font-bold text-white/80 uppercase tracking-wider mt-2">{{ unit.label }}</span>
                    </div>
                </div>

                <RouterLink :to="route('products.index')" class="inline-flex items-center gap-2 h-12 px-6 bg-white text-red-600 rounded-xl font-bold hover:scale-105 transition-transform shadow-lg whitespace-nowrap">
                    Дивитись акції
                    <i class="ri-arrow-right-line"></i>
                </RouterLink>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ШВИДКІ КАТЕГОРІЇ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-12" v-if="categories?.length">
        <div class="container-app">
            <div class="flex gap-4 md:gap-6 overflow-x-auto pb-6 scrollbar-hide snap-x px-4 -mx-4 md:mx-0 md:px-0">
                <RouterLink
                    v-for="(category, index) in categories.slice(0, 8)"
                    :key="category.id"
                    :to="route('categories.show', category.slug)"
                    class="snap-start flex-shrink-0 flex flex-col items-center gap-4 w-28 sm:w-32 group"
                >
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[1.5rem] bg-white/70 backdrop-blur-xl border border-white/50 shadow-xl shadow-brand-500/5 flex items-center justify-center text-surface-600 group-hover:bg-gradient-to-br group-hover:from-brand-500 group-hover:to-indigo-600 group-hover:border-transparent group-hover:text-white group-hover:shadow-2xl group-hover:shadow-brand-500/30 group-hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i :class="getCategoryIcon(index)" class="text-3xl sm:text-4xl relative z-10 drop-shadow-sm"></i>
                    </div>
                    <span class="text-sm sm:text-base font-bold text-surface-700 text-center leading-tight group-hover:text-brand-600 transition-colors">{{ category.name }}</span>
                </RouterLink>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ГАРЯЧІ ПРОПОЗИЦІЇ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16" v-if="most_sold_in_store?.length">
        <div class="container-app">
            <div class="flex items-end justify-between mb-10">
                <div class="relative">
                    <div class="absolute -inset-4 bg-brand-500/20 blur-2xl rounded-full z-0"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 flex items-center justify-center">
                                <i class="ri-fire-fill text-2xl animate-pulse"></i>
                            </div>
                            <span class="text-red-500 font-bold uppercase tracking-wider text-sm">Встигни придбати</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-surface-900 tracking-tight">Гарячі пропозиції</h2>
                    </div>
                </div>
                <RouterLink :to="route('products.index')" class="hidden sm:flex items-center gap-2 px-6 py-3 rounded-xl bg-white/50 backdrop-blur border border-white/50 text-brand-600 font-bold hover:bg-white hover:shadow-lg transition-all group">
                    Всі товари
                    <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                </RouterLink>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                <ProductCard
                    v-for="product in most_sold_in_store"
                    :key="product.id"
                    :product="product"
                    badge="hot"
                />
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ПОПУЛЯРНЕ В ТВОЄМУ РЕГІОНІ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16" v-if="most_sold_in_region?.length">
        <div class="container-app">
            <div class="flex items-end justify-between mb-10">
                <div class="relative">
                    <div class="absolute -inset-4 bg-indigo-500/20 blur-2xl rounded-full z-0"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center">
                                <i class="ri-map-pin-fill text-2xl"></i>
                            </div>
                            <span class="text-indigo-500 font-bold uppercase tracking-wider text-sm">
                                Тренди {{ region || 'твого регіону' }}
                            </span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-surface-900 tracking-tight">Обирають поруч з тобою</h2>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                <ProductCard
                    v-for="product in most_sold_in_region"
                    :key="product.id"
                    :product="product"
                    badge="trend"
                />
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ЯСКРАВІ ПРОМО-БАНЕРИ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-12">
        <div class="container-app">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <RouterLink :to="route('products.index')" class="relative h-[300px] rounded-[2.5rem] overflow-hidden group shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 group-hover:scale-105 transition-transform duration-700"></div>
                    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
                    <div class="relative z-10 h-full p-10 flex flex-col justify-center w-2/3">
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-white font-bold uppercase tracking-wider text-xs mb-4 w-fit">Топ вибір</span>
                        <h3 class="text-3xl sm:text-4xl font-black text-white mb-4 drop-shadow-md">Розумні годинники</h3>
                        <p class="text-white/80 mb-8 font-medium">Новий рівень контролю твого здоров'я.</p>
                        <span class="w-12 h-12 rounded-full bg-white text-indigo-600 flex items-center justify-center group-hover:translate-x-2 shadow-lg transition-transform">
                            <i class="ri-arrow-right-line text-xl"></i>
                        </span>
                    </div>
                    <i class="ri-watch-line absolute -bottom-10 -right-10 text-[200px] text-white/20 rotate-[-15deg] group-hover:rotate-0 transition-transform duration-700"></i>
                </RouterLink>

                <RouterLink :to="route('products.index')" class="relative h-[300px] rounded-[2.5rem] overflow-hidden group shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-bl from-brand-600 via-blue-600 to-cyan-500 group-hover:scale-105 transition-transform duration-700"></div>
                    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
                    <div class="relative z-10 h-full p-10 flex flex-col justify-center items-end text-right ml-auto w-2/3">
                        <span class="inline-block px-3 py-1 bg-amber-400/90 backdrop-blur-md rounded-lg text-amber-950 font-black uppercase tracking-wider text-xs mb-4 w-fit shadow-md">-30% Знижка</span>
                        <h3 class="text-3xl sm:text-4xl font-black text-white mb-4 drop-shadow-md">Ігрові ноутбуки</h3>
                        <p class="text-white/80 mb-8 font-medium">Потужність, якої вистачить на все.</p>
                        <span class="w-12 h-12 rounded-full bg-white text-brand-600 flex items-center justify-center group-hover:-translate-x-2 shadow-lg transition-transform">
                            <i class="ri-arrow-left-line text-xl"></i>
                        </span>
                    </div>
                    <i class="ri-macbook-line absolute -top-10 -left-10 text-[200px] text-white/20 rotate-[15deg] group-hover:rotate-0 transition-transform duration-700"></i>
                </RouterLink>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         БРЕНДИ-ПАРТНЕРИ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="container-app">
            <div class="text-center mb-10">
                <span class="inline-block px-4 py-1.5 rounded-full bg-brand-100 text-brand-600 font-bold uppercase tracking-wider text-xs mb-3">Офіційні партнери</span>
                <h2 class="text-3xl sm:text-4xl font-black text-surface-900 tracking-tight">Тільки оригінальна продукція</h2>
            </div>

            <div class="relative overflow-hidden rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white shadow-xl py-8">
                <!-- Градієнтні маски по краях -->
                <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                <!-- Стрічка брендів -->
                <div class="flex gap-12 md:gap-20 animate-marquee whitespace-nowrap">
                    <div
                        v-for="brand in [...brands, ...brands]"
                        :key="`${brand.name}-${Math.random()}`"
                        class="flex items-center justify-center w-[140px] flex-shrink-0 grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all"
                        :title="brand.name"
                    >
                        <i :class="brand.icon" class="text-5xl text-surface-700"></i>
                        <span class="ml-3 font-black text-2xl text-surface-700">{{ brand.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ВІДГУКИ КЛІЄНТІВ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="container-app">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 font-bold uppercase tracking-wider text-xs mb-3">
                    <i class="ri-star-fill"></i>
                    4.9 із 5 за відгуками
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-surface-900 tracking-tight mb-4">Що кажуть наші клієнти</h2>
                <p class="text-surface-500 text-lg max-w-2xl mx-auto">Понад 50 000 задоволених покупців довіряють нам</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    v-for="review in reviews"
                    :key="review.id"
                    class="relative bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all group"
                >
                    <i class="ri-double-quotes-l absolute top-4 right-6 text-6xl text-brand-100 group-hover:text-brand-200 transition-colors"></i>

                    <div class="flex items-center gap-1 text-amber-400 mb-4 relative z-10">
                        <i v-for="n in 5" :key="n" class="ri-star-fill"></i>
                    </div>

                    <p class="text-surface-700 mb-6 leading-relaxed relative z-10">{{ review.text }}</p>

                    <div class="flex items-center gap-3 relative z-10">
                        <div
                            class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md"
                            :class="review.avatarBg"
                        >
                            {{ review.name.charAt(0) }}
                        </div>
                        <div>
                            <div class="font-bold text-surface-900">{{ review.name }}</div>
                            <div class="text-sm text-surface-500">{{ review.location }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Статистика -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="bg-white/60 backdrop-blur-xl p-6 rounded-2xl border border-white text-center shadow"
                >
                    <div class="text-3xl md:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600 mb-1">
                        {{ stat.value }}
                    </div>
                    <div class="text-sm font-medium text-surface-500">{{ stat.label }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         ПЕРЕВАГИ МАГАЗИНУ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-20 mt-10 relative">
        <div class="absolute inset-0 bg-white rounded-t-[4rem] shadow-[0_-20px_40px_rgba(0,0,0,0.02)]"></div>
        <div class="container-app relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="feature in features"
                    :key="feature.title"
                    :class="[
                        'p-8 rounded-[2rem] border transition-all group',
                        feature.bg,
                        feature.borderHover,
                        'hover:bg-white hover:shadow-xl'
                    ]"
                >
                    <div
                        :class="[
                            'w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner',
                            feature.iconBg,
                            feature.iconRotate
                        ]"
                    >
                        <i :class="feature.icon" class="text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-surface-900 mb-2">{{ feature.title }}</h4>
                    <p class="text-surface-500">{{ feature.description }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         БЛОГ / НОВИНИ
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white">
        <div class="container-app">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-pink-100 text-pink-600 font-bold uppercase tracking-wider text-xs mb-3">Корисне</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-surface-900 tracking-tight">Новини та огляди</h2>
                </div>
                <RouterLink :to="'#'" class="hidden sm:flex items-center gap-2 px-6 py-3 rounded-xl border border-surface-200 text-surface-700 font-bold hover:bg-surface-50 transition-all group">
                    Всі статті
                    <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                </RouterLink>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <RouterLink
                    v-for="post in blogPosts"
                    :key="post.id"
                    :to="'#'"
                    class="group flex flex-col rounded-[2rem] overflow-hidden bg-surface-50 border border-surface-100 hover:border-brand-200 hover:shadow-xl transition-all"
                >
                    <div class="aspect-[16/10] overflow-hidden relative">
                        <div
                            class="absolute inset-0 transition-transform duration-700 group-hover:scale-110"
                            :class="post.bgGradient"
                        ></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white/20 to-transparent"></div>
                        <i :class="post.icon" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[120px] text-white/40"></i>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-lg bg-white/90 backdrop-blur text-xs font-bold uppercase tracking-wider text-surface-900">{{ post.category }}</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-surface-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">{{ post.title }}</h3>
                        <p class="text-sm text-surface-500 mb-4 line-clamp-2">{{ post.excerpt }}</p>
                        <div class="flex items-center gap-2 text-xs text-surface-400 mt-auto">
                            <i class="ri-time-line"></i>
                            <span>{{ post.readTime }}</span>
                            <span>·</span>
                            <span>{{ post.date }}</span>
                        </div>
                    </div>
                </RouterLink>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
         CTA NEWSLETTER
         ═══════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white">
        <div class="container-app">
            <div class="relative rounded-[2.5rem] overflow-hidden bg-gradient-to-br from-surface-950 via-brand-950 to-indigo-950 p-10 md:p-16 shadow-2xl">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-500/30 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-500/20 rounded-full blur-[100px]"></div>

                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md w-fit mb-6">
                        <i class="ri-mail-fill text-amber-400"></i>
                        <span class="text-xs font-bold uppercase tracking-widest text-white">Розсилка</span>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">
                        Знижка 10% на перше замовлення
                    </h2>
                    <p class="text-white/70 text-lg mb-8">Підпишись і отримуй ексклюзивні пропозиції першим.</p>

                    <form @submit.prevent="subscribeNewsletter" class="flex flex-col sm:flex-row gap-3">
                        <input
                            v-model="newsletterEmail"
                            type="email"
                            required
                            placeholder="your@email.com"
                            class="flex-1 h-14 px-6 rounded-2xl bg-white/10 border border-white/20 backdrop-blur text-white placeholder-white/50 focus:outline-none focus:border-white/50 transition-colors"
                        >
                        <button
                            type="submit"
                            :disabled="newsletterLoading"
                            class="h-14 px-8 bg-white text-surface-950 rounded-2xl font-bold hover:scale-105 transition-transform shadow-xl disabled:opacity-50 disabled:hover:scale-100 whitespace-nowrap"
                        >
                            {{ newsletterLoading ? 'Зачекайте...' : 'Підписатись' }}
                        </button>
                    </form>
                    <p v-if="newsletterMessage" class="text-sm text-emerald-300 mt-3">{{ newsletterMessage }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Head } from '@/shared/lib/spa-compat'
import { ProductCatalogCard as ProductCard } from '@/widgets/product-catalog'

// ═══════════════════════════════════════════════════════════
// PROPS
// ═══════════════════════════════════════════════════════════
const props = defineProps({
    categories:           { type: Array,  default: () => [] },
    most_sold_in_store:   { type: Array,  default: () => [] },
    most_sold_in_region:  { type: Array,  default: () => [] },
    region:               { type: String, default: '' },
})

// ═══════════════════════════════════════════════════════════
// HERO CAROUSEL — стан і автоплей
// ═══════════════════════════════════════════════════════════
const heroSlides = [
    {
        id: 1,
        bgClass: 'bg-gradient-to-br from-surface-950 via-zinc-900 to-zinc-800',
        badge: 'Новинка сезону',
        badgeIcon: 'ri-flashlight-fill',
        titleLine1: 'iPhone 15 Pro',
        titleLine2: 'Titanium',
        titleAccent: 'bg-gradient-to-r from-zinc-300 to-zinc-500',
        description: 'Викуваний з титану. Новий чіп A17 Pro. Абсолютно нова кнопка дії.',
        ctaText: 'Передзамовити',
        ctaLink: route('products.index'),
        price: 'від 49 999 ₴',
        image: 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=1000',
        floatIcon: 'ri-apple-fill',
    },
    {
        id: 2,
        bgClass: 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900',
        badge: 'Безпровідний звук',
        badgeIcon: 'ri-music-2-fill',
        titleLine1: 'Sony WH-1000',
        titleLine2: 'Тиша преміум-класу',
        titleClass: 'text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-5xl',
        titleAccent: 'bg-gradient-to-r from-pink-300 to-purple-300',
        description: 'Найкраще придушення шуму у своєму класі. До 30 годин автономності.',
        ctaText: 'Купити',
        ctaLink: route('products.index'),
        price: 'від 14 999 ₴',
        image: 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&q=80&w=1000',
        floatIcon: 'ri-headphone-fill',
    },
    {
        id: 3,
        bgClass: 'bg-gradient-to-br from-emerald-900 via-teal-900 to-cyan-900',
        badge: 'Для геймерів',
        badgeIcon: 'ri-gamepad-fill',
        titleLine1: 'ASUS ROG',
        titleLine2: 'Ігрові ноутбуки',
        titleAccent: 'bg-gradient-to-r from-cyan-300 to-emerald-300',
        description: 'RTX 4080, 32 ГБ DDR5 і 240 Гц екран. Створено для перемог.',
        ctaText: 'Переглянути',
        ctaLink: route('products.index'),
        price: 'від 79 999 ₴',
        image: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&q=80&w=1000',
        floatIcon: 'ri-macbook-fill',
    },
    {
        id: 4,
        bgClass: 'bg-gradient-to-br from-rose-900 via-red-900 to-orange-900',
        badge: '-30% Знижка',
        badgeIcon: 'ri-fire-fill',
        titleLine1: 'Розпродаж',
        titleLine2: 'Sale Season',
        titleAccent: 'bg-gradient-to-r from-amber-300 to-orange-300',
        description: 'Сотні товарів зі знижками. Не пропусти найгарячіші пропозиції року.',
        ctaText: 'До акції',
        ctaLink: route('products.index'),
        price: '',
        image: 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&q=80&w=1000',
        floatIcon: 'ri-price-tag-3-fill',
    },
]

const activeSlide = ref(0)
const slideProgress = ref(0)
const SLIDE_DURATION = 6000
let slideInterval = null
let progressInterval = null
let isPaused = false

const startAutoplay = () => {
    stopAutoplay()
    slideProgress.value = 0
    progressInterval = setInterval(() => {
        if (!isPaused) {
            slideProgress.value += 100 / (SLIDE_DURATION / 100)
            if (slideProgress.value >= 100) slideProgress.value = 100
        }
    }, 100)
    slideInterval = setInterval(() => {
        if (!isPaused) nextSlide()
    }, SLIDE_DURATION)
}

const stopAutoplay = () => {
    clearInterval(slideInterval)
    clearInterval(progressInterval)
}

const nextSlide = () => {
    activeSlide.value = (activeSlide.value + 1) % heroSlides.length
    slideProgress.value = 0
}

const prevSlide = () => {
    activeSlide.value = (activeSlide.value - 1 + heroSlides.length) % heroSlides.length
    slideProgress.value = 0
}

const goToSlide = (idx) => {
    activeSlide.value = idx
    slideProgress.value = 0
}

const pauseSlider = () => { isPaused = true }
const resumeSlider = () => { isPaused = false }

// ═══════════════════════════════════════════════════════════
// COUNTDOWN — до кінця доби
// ═══════════════════════════════════════════════════════════
const now = ref(new Date())
let countdownInterval = null

const countdownUnits = computed(() => {
    const end = new Date()
    end.setHours(23, 59, 59, 999)
    const diff = Math.max(0, end - now.value)

    const hours   = Math.floor(diff / (1000 * 60 * 60))
    const minutes = Math.floor((diff / (1000 * 60)) % 60)
    const seconds = Math.floor((diff / 1000) % 60)

    return [
        { label: 'Год', value: hours },
        { label: 'Хв',  value: minutes },
        { label: 'Сек', value: seconds },
    ]
})

// ═══════════════════════════════════════════════════════════
// СТАТИЧНІ ДАНІ
// ═══════════════════════════════════════════════════════════
const categoryIcons = [
    'ri-macbook-line',
    'ri-smartphone-line',
    'ri-headphone-line',
    'ri-gamepad-line',
    'ri-camera-3-line',
    'ri-tv-2-line',
    'ri-watch-line',
    'ri-plug-line',
]
const getCategoryIcon = (idx) => categoryIcons[idx] || 'ri-shopping-bag-line'

const brands = [
    { name: 'Apple',   icon: 'ri-apple-fill' },
    { name: 'Samsung', icon: 'ri-smartphone-fill' },
    { name: 'Sony',    icon: 'ri-headphone-fill' },
    { name: 'Xiaomi',  icon: 'ri-cellphone-fill' },
    { name: 'Asus',    icon: 'ri-macbook-fill' },
    { name: 'Lenovo',  icon: 'ri-computer-fill' },
    { name: 'JBL',     icon: 'ri-speaker-fill' },
    { name: 'Garmin',  icon: 'ri-watch-fill' },
]

const reviews = [
    {
        id: 1,
        name: 'Олена',
        location: 'Київ',
        text: 'Замовила навушники, прийшли наступного дня. Все офіційно, з гарантією. Дуже задоволена сервісом!',
        avatarBg: 'bg-gradient-to-br from-pink-500 to-rose-600',
    },
    {
        id: 2,
        name: 'Дмитро',
        location: 'Львів',
        text: 'Купував ноутбук для роботи. Менеджер допоміг з вибором, доставка швидка, ціна приємна. Рекомендую!',
        avatarBg: 'bg-gradient-to-br from-brand-500 to-indigo-600',
    },
    {
        id: 3,
        name: 'Андрій',
        location: 'Дніпро',
        text: 'Замовляю тут вже втретє. Підтримка завжди на зв\'язку, всі питання вирішують швидко. Топ магазин!',
        avatarBg: 'bg-gradient-to-br from-emerald-500 to-teal-600',
    },
]

const stats = [
    { value: '50K+',  label: 'Клієнтів'         },
    { value: '4.9★',  label: 'Середній рейтинг' },
    { value: '24/7',  label: 'Підтримка'        },
    { value: '14 дн', label: 'Гарантія повернення' },
]

const features = [
    {
        title: 'Швидка доставка',
        description: 'Безкоштовно для замовлень від 1000 ₴ прямо до ваших дверей.',
        icon: 'ri-truck-fill',
        bg: 'bg-surface-50 border-surface-100',
        borderHover: 'hover:border-brand-200',
        iconBg: 'bg-gradient-to-br from-brand-100 to-brand-50 text-brand-600',
        iconRotate: 'group-hover:rotate-3',
    },
    {
        title: 'Офіційна гарантія',
        description: 'До 36 місяців гарантійного обслуговування на всю техніку.',
        icon: 'ri-shield-check-fill',
        bg: 'bg-surface-50 border-surface-100',
        borderHover: 'hover:border-indigo-200',
        iconBg: 'bg-gradient-to-br from-indigo-100 to-indigo-50 text-indigo-600',
        iconRotate: 'group-hover:-rotate-3',
    },
    {
        title: 'Легке повернення',
        description: 'Можливість повернути товар протягом 14 днів без питань.',
        icon: 'ri-refresh-fill',
        bg: 'bg-surface-50 border-surface-100',
        borderHover: 'hover:border-pink-200',
        iconBg: 'bg-gradient-to-br from-pink-100 to-pink-50 text-pink-600',
        iconRotate: 'group-hover:rotate-3',
    },
    {
        title: 'Підтримка 24/7',
        description: 'Наші фахівці завжди готові допомогти вам з вибором.',
        icon: 'ri-customer-service-2-fill',
        bg: 'bg-surface-50 border-surface-100',
        borderHover: 'hover:border-amber-200',
        iconBg: 'bg-gradient-to-br from-amber-100 to-amber-50 text-amber-600',
        iconRotate: 'group-hover:-rotate-3',
    },
]

const blogPosts = [
    {
        id: 1,
        category: 'Огляд',
        title: 'iPhone 15 Pro: чи варто оновлювати з 14-го?',
        excerpt: 'Детальний огляд флагмана Apple — що нового і кому це підійде.',
        readTime: '5 хв',
        date: '2 дні тому',
        bgGradient: 'bg-gradient-to-br from-zinc-700 to-zinc-900',
        icon: 'ri-smartphone-fill',
    },
    {
        id: 2,
        category: 'Гайд',
        title: 'Як обрати ігровий ноутбук у 2026',
        excerpt: 'Розбираємо ключові характеристики, на які варто звернути увагу.',
        readTime: '7 хв',
        date: 'Тиждень тому',
        bgGradient: 'bg-gradient-to-br from-brand-600 to-indigo-700',
        icon: 'ri-macbook-fill',
    },
    {
        id: 3,
        category: 'Поради',
        title: '10 аксесуарів, які варто мати кожному',
        excerpt: 'Підбірка корисних гаджетів, що зроблять життя зручнішим.',
        readTime: '4 хв',
        date: '2 тижні тому',
        bgGradient: 'bg-gradient-to-br from-pink-500 to-rose-600',
        icon: 'ri-headphone-fill',
    },
]

// ═══════════════════════════════════════════════════════════
// NEWSLETTER
// ═══════════════════════════════════════════════════════════
const newsletterEmail   = ref('')
const newsletterLoading = ref(false)
const newsletterMessage = ref('')

const subscribeNewsletter = async () => {
    newsletterLoading.value = true
    // TODO: підключити API client post('/newsletter', { email: newsletterEmail.value })
    setTimeout(() => {
        newsletterLoading.value = false
        newsletterMessage.value = '✓ Підписка оформлена! Перевір пошту.'
        newsletterEmail.value   = ''
    }, 800)
}

// ═══════════════════════════════════════════════════════════
// LAZY LOAD ProductCard (винесено в окремий компонент)
// ═══════════════════════════════════════════════════════════

// ═══════════════════════════════════════════════════════════
// LIFECYCLE
// ═══════════════════════════════════════════════════════════
onMounted(() => {
    startAutoplay()
    countdownInterval = setInterval(() => {
        now.value = new Date()
    }, 1000)
})

onBeforeUnmount(() => {
    stopAutoplay()
    clearInterval(countdownInterval)
})
</script>

<style scoped>
/* Кастомні анімації */
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(12deg); }
    50%      { transform: translateY(-10px) rotate(12deg); }
}
@keyframes float-slow {
    0%, 100% { transform: translateY(0) rotate(-5deg); }
    50%      { transform: translateY(-8px) rotate(-5deg); }
}
@keyframes marquee {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; }
    50%      { opacity: 0.6; }
}
@keyframes slide-down {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.animate-float        { animation: float 4s ease-in-out infinite; }
.animate-float-slow   { animation: float-slow 6s ease-in-out infinite; }
.animate-marquee      { animation: marquee 40s linear infinite; }
.animate-pulse-slow   { animation: pulse-slow 6s ease-in-out infinite; }
.animate-pulse-slower { animation: pulse-slow 8s ease-in-out infinite; }

.animate-slide-down         { animation: slide-down 0.6s ease-out; }
.animate-slide-up           { animation: slide-up 0.6s ease-out 0.1s both; }
.animate-slide-up-delayed   { animation: slide-up 0.6s ease-out 0.2s both; }
.animate-slide-up-delayed-2 { animation: slide-up 0.6s ease-out 0.3s both; }

/* Hero slide transitions */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.8s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
}

/* Reduce-motion support */
@media (prefers-reduced-motion: reduce) {
    .animate-float,
    .animate-float-slow,
    .animate-marquee,
    .animate-pulse-slow,
    .animate-pulse-slower,
    .animate-slide-down,
    .animate-slide-up,
    .animate-slide-up-delayed,
    .animate-slide-up-delayed-2 {
        animation: none;
    }
}

/* Scrollbar hide для категорій */
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { scrollbar-width: none; -ms-overflow-style: none; }
</style>
