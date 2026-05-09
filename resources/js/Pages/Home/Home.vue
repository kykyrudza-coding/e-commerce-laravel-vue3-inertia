<template>
    <Head title="Головна" />

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-surface-950">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0">
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
            <!-- Glows -->
            <div class="absolute top-0 -translate-y-[20%] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-brand-600/30 rounded-full blur-[120px] pointer-events-none mix-blend-screen"></div>
            <div class="absolute bottom-0 translate-y-[20%] right-0 w-[600px] h-[600px] bg-indigo-600/20 rounded-full blur-[100px] pointer-events-none mix-blend-screen"></div>
        </div>

        <div class="container-app relative z-10 py-20 text-center animate-fade-in">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-900/50 border border-white/10 backdrop-blur-md mb-8 hover:bg-surface-800/50 transition-colors cursor-default">
                <span class="flex h-2 w-2 rounded-full bg-brand-500 animate-pulse"></span>
                <span class="text-sm font-medium text-surface-200">Відкрийте майбутнє електроніки</span>
            </div>

            <!-- Headline -->
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold text-white tracking-tight leading-[1.1] mb-8 max-w-5xl mx-auto">
                Технології, які <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-indigo-400 to-purple-400">
                    надихають на більше
                </span>
            </h1>

            <!-- Description -->
            <p class="text-lg md:text-xl text-surface-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                Досліджуйте світ преміальної техніки. Від новітніх смартфонів до потужних ноутбуків — усе необхідне для вашого цифрового життя.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <Link :href="route('products.index')" class="w-full sm:w-auto h-14 px-8 inline-flex items-center justify-center gap-2 rounded-full bg-white text-surface-950 font-bold hover:bg-surface-100 hover:scale-[1.02] transition-all duration-300 shadow-[0_0_40px_-10px_rgba(255,255,255,0.3)]">
                    Перейти до каталогу
                    <i class="ri-arrow-right-line"></i>
                </Link>
                <Link :href="route('about')" class="w-full sm:w-auto h-14 px-8 inline-flex items-center justify-center gap-2 rounded-full bg-surface-800/50 text-white font-medium border border-surface-700 hover:bg-surface-800 hover:border-surface-600 backdrop-blur-md transition-all duration-300">
                    <i class="ri-information-line"></i>
                    Про нас
                </Link>
            </div>
        </div>
        
        <!-- Bottom Fade -->
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-surface-50 to-transparent z-10"></div>
    </section>

    <!-- Bento Features Section -->
    <section class="py-20 relative z-20 -mt-16">
        <div class="container-app">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1 md:col-span-2 card bg-white p-8 rounded-3xl border border-surface-100 shadow-xl shadow-surface-200/20 group hover:border-brand-200 transition-colors">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ri-rocket-line text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-surface-900 mb-3">Блискавична доставка</h3>
                    <p class="text-surface-600 leading-relaxed max-w-md">Ми співпрацюємо з провідними логістичними компаніями, щоб ви отримали свій новий гаджет вже наступного дня після замовлення.</p>
                </div>
                
                <div class="col-span-1 card bg-surface-900 p-8 rounded-3xl border border-surface-800 text-white group hover:border-brand-500/50 transition-colors">
                    <div class="w-14 h-14 rounded-2xl bg-surface-800 text-brand-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ri-shield-check-line text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Офіційна гарантія</h3>
                    <p class="text-surface-400 leading-relaxed">Лише сертифікована техніка з гарантією від виробника.</p>
                </div>

                <div class="col-span-1 card bg-gradient-to-br from-brand-50 to-indigo-50 p-8 rounded-3xl border border-brand-100 group">
                    <div class="w-14 h-14 rounded-2xl bg-white text-brand-600 shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ri-refresh-line text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-surface-900 mb-3">Легке повернення</h3>
                    <p class="text-surface-600 leading-relaxed">30 днів на роздуми. Повернення без зайвих питань.</p>
                </div>

                <div class="col-span-1 md:col-span-2 card bg-white p-8 rounded-3xl border border-surface-100 shadow-xl shadow-surface-200/20 group hover:border-indigo-200 transition-colors flex flex-col justify-center relative overflow-hidden">
                    <!-- Background graphic -->
                    <div class="absolute -right-8 -bottom-8 opacity-5 text-surface-900">
                        <i class="ri-customer-service-2-fill text-[200px]"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <i class="ri-customer-service-2-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-surface-900 mb-3">Підтримка 24/7</h3>
                        <p class="text-surface-600 leading-relaxed max-w-md">Наша команда експертів завжди готова допомогти вам з вибором, налаштуванням або вирішенням будь-яких питань.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Products Grid -->
    <section class="py-24 bg-surface-50">
        <div class="container-app">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-100 text-brand-700 text-xs font-bold uppercase tracking-wider mb-4">
                        <i class="ri-star-fill"></i> Топ продажів
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold text-surface-900 tracking-tight">Хіти магазину</h2>
                </div>
                <Link :href="route('products.index')" class="group flex items-center gap-2 text-surface-600 hover:text-brand-600 font-medium transition-colors">
                    Дивитись всі товари 
                    <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                </Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <Link
                    v-for="product in most_sold_in_store"
                    :key="product.id"
                    :href="route('products.show', product.slug)"
                    class="card bg-white p-5 rounded-3xl border border-surface-200 hover:border-brand-300 hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-300 group flex flex-col h-full"
                >
                    <div class="aspect-square rounded-2xl bg-surface-50 mb-5 p-4 flex items-center justify-center overflow-hidden relative">
                        <img
                            v-if="product.image"
                            :src="product.image"
                            :alt="product.name"
                            class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500"
                        />
                        <div v-else class="text-surface-300">
                            <i class="ri-image-line text-4xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-surface-900 mb-2 line-clamp-2 group-hover:text-brand-600 transition-colors">
                            {{ product.name }}
                        </h3>
                        <div class="mt-auto pt-4 flex items-center justify-between">
                            <span class="text-xl font-black text-surface-900">{{ formatPrice(product.price) }}</span>
                            <span class="w-10 h-10 rounded-full bg-surface-100 flex items-center justify-center text-surface-600 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                                <i class="ri-arrow-right-up-line"></i>
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </section>

    <!-- Regional & Categories -->
    <section class="py-24 bg-white relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-surface-50 to-transparent pointer-events-none"></div>

        <div class="container-app">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Popular in Region -->
                <div class="lg:col-span-7">
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-surface-900 tracking-tight mb-2">Популярне поруч</h2>
                        <p class="text-surface-500">Топ продажів у регіоні "{{ region }}"</p>
                    </div>

                    <div class="space-y-4">
                        <Link
                            v-for="product in most_sold_in_region.slice(0, 4)"
                            :key="product.id"
                            :href="route('products.show', product.slug)"
                            class="flex items-center gap-5 p-4 rounded-2xl border border-surface-100 hover:border-brand-200 hover:bg-brand-50/30 transition-all duration-300 group"
                        >
                            <div class="w-20 h-20 rounded-xl bg-surface-50 flex items-center justify-center flex-shrink-0 p-2 overflow-hidden">
                                <img
                                    v-if="product.image"
                                    :src="product.image"
                                    :alt="product.name"
                                    class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-surface-900 truncate group-hover:text-brand-600 transition-colors">
                                    {{ product.name }}
                                </h3>
                                <p class="text-brand-600 font-bold mt-1">{{ formatPrice(product.price) }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-surface-200 flex items-center justify-center text-surface-400 group-hover:border-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all flex-shrink-0">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Categories -->
                <div class="lg:col-span-5" v-if="categories?.length">
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-surface-900 tracking-tight mb-2">Категорії</h2>
                        <p class="text-surface-500">Оберіть потрібний розділ</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <Link
                            v-for="(category, index) in categories.slice(0, 6)"
                            :key="category.id"
                            :href="route('categories.show', category.slug)"
                            class="card p-6 rounded-2xl border border-surface-100 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 group text-center flex flex-col items-center justify-center gap-3 bg-surface-50 hover:bg-white"
                        >
                            <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-brand-500 group-hover:scale-110 group-hover:bg-brand-500 group-hover:text-white transition-all duration-300">
                                <i class="ri-macbook-line text-xl" v-if="index === 0"></i>
                                <i class="ri-smartphone-line text-xl" v-else-if="index === 1"></i>
                                <i class="ri-headphone-line text-xl" v-else-if="index === 2"></i>
                                <i class="ri-gamepad-line text-xl" v-else-if="index === 3"></i>
                                <i class="ri-camera-3-line text-xl" v-else-if="index === 4"></i>
                                <i class="ri-watch-line text-xl" v-else></i>
                            </div>
                            <span class="font-medium text-surface-800 group-hover:text-brand-600 transition-colors">{{ category.name }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 relative overflow-hidden bg-brand-900 text-white">
        <!-- Glows -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-brand-500/40 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="container-app relative z-10 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">Готові до покупок?</h2>
            <p class="text-brand-100 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                Приєднуйтесь до тисяч задоволених клієнтів. Створіть акаунт прямо зараз та отримайте доступ до спеціальних пропозицій.
            </p>
            <Link :href="route('register')" class="h-14 px-10 inline-flex items-center justify-center rounded-full bg-white text-brand-900 font-bold hover:scale-105 transition-transform shadow-[0_0_30px_-5px_rgba(255,255,255,0.4)]">
                Створити акаунт
            </Link>
        </div>
    </section>
</template>

<script setup>
import { formatPrice } from '@/utils/helpers.js';

defineProps({
    categories:           { type: Array, default: () => [] },
    most_sold_in_store:   { type: Array, default: () => [] },
    most_sold_in_region:  { type: Array, default: () => [] },
    region:               { type: String, default: '' },
});
</script>
