<template>
    <Head :title="isLoading ? 'Завантаження товару' : product.name" />

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-[-1] bg-surface-50 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
    </div>

    <div class="container-app py-8">
        <ProductDetailsSkeleton v-if="isLoading" />

        <template v-else>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-surface-400 mb-8 flex-wrap" aria-label="Breadcrumb">
                <RouterLink :to="route('home')" class="hover:text-brand-600 transition-colors">Головна</RouterLink>
                <i class="ri-arrow-right-s-line"></i>
                <RouterLink :to="route('products.index')" class="hover:text-brand-600 transition-colors">Каталог</RouterLink>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-surface-900 font-bold truncate max-w-xs">{{ product.name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
                <!-- Images -->
                <div class="animate-slide-up">
                    <!-- Main image -->
                    <div class="aspect-square rounded-[2rem] overflow-hidden bg-white/70 backdrop-blur-xl border border-white shadow-xl shadow-brand-500/5 mb-4 relative group">
                        <img
                            v-if="activeImage"
                            :src="imageUrl(domain, activeImage.image_path)"
                            :alt="product.name"
                            class="w-full h-full object-contain p-8 mix-blend-multiply transition-transform duration-500 group-hover:scale-105"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                            <i class="ri-image-2-line text-6xl"></i>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex gap-3 overflow-x-auto scrollbar-hide py-1 px-1">
                        <button
                            v-for="img in sortedImages"
                            :key="img.id"
                            @click="activeImage = img"
                            :class="[
                                'flex-shrink-0 w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all duration-200 bg-white shadow-sm',
                                activeImage?.id === img.id ? 'border-brand-500 shadow-md scale-105' : 'border-white hover:border-brand-200 hover:shadow-md'
                            ]"
                        >
                            <img :src="imageUrl(domain, img.image_path)" :alt="product.name" class="w-full h-full object-contain mix-blend-multiply p-2" />
                        </button>
                    </div>
                </div>

                <!-- Product info -->
                <div class="animate-slide-up-delayed">
                    <h1 class="text-3xl lg:text-4xl font-black text-surface-900 mb-4 tracking-tight drop-shadow-sm">{{ product.name }}</h1>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3 mb-8">
                        <span class="text-4xl lg:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600 drop-shadow-sm">{{ formatPrice(product.price) }}</span>
                    </div>

                    <!-- Description -->
                    <p class="text-surface-600 text-lg leading-relaxed mb-8 font-medium">{{ product.description }}</p>

                    <!-- Characteristics -->
                    <div v-if="Object.keys(characteristics).length" class="mb-10">
                        <h3 class="text-lg font-bold text-surface-900 mb-4">Характеристики</h3>
                        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] shadow-lg shadow-surface-200/50 divide-y divide-surface-200/50 overflow-hidden">
                            <div
                                v-for="(item, key) in characteristics"
                                :key="key"
                                class="flex items-center justify-between px-6 py-4 text-sm"
                            >
                                <span class="text-surface-500 font-medium">{{ item.name }}</span>
                                <span class="font-bold text-surface-900">{{ item.value }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <button
                            @click="handleAddToCart"
                            :disabled="adding"
                            class="h-16 px-8 rounded-2xl flex items-center justify-center gap-3 font-bold text-lg transition-all flex-1"
                            :class="added ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 shadow-inner' : 'bg-white text-brand-600 border border-brand-200 hover:bg-brand-50 hover:border-brand-300 shadow-lg shadow-brand-500/10'"
                            id="product-show-add-cart-btn"
                        >
                            <i :class="adding ? 'ri-loader-4-line animate-spin' : added ? 'ri-check-double-line' : 'ri-shopping-bag-3-line'" class="text-2xl"></i>
                            {{ added ? 'Додано!' : adding ? 'Додаємо...' : 'В кошик' }}
                        </button>

                        <button
                            @click="buyNow"
                            class="h-16 px-8 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white font-black text-lg flex items-center justify-center gap-3 hover:from-brand-500 hover:to-indigo-500 transition-all shadow-xl shadow-brand-500/30 flex-1 hover:scale-[1.02]"
                            id="product-show-buy-now-btn"
                        >
                            <i class="ri-flash-fill text-2xl"></i>
                            Купити зараз
                        </button>
                    </div>

                    <!-- Review button -->
                    <button
                        @click="reviewModalOpen = true"
                        class="h-14 w-full rounded-xl bg-surface-100/50 hover:bg-white text-surface-600 hover:text-brand-600 font-bold transition-all flex items-center justify-center gap-2 border border-transparent hover:border-surface-200 hover:shadow-md"
                        id="product-show-review-btn"
                    >
                        <i class="ri-star-smile-fill text-lg text-amber-400"></i>
                        Залишити відгук
                    </button>
                </div>
            </div>

            <!-- Reviews -->
            <section v-if="reviews" class="mt-24">
                <div class="flex items-center gap-3 mb-8">
                    <h2 class="text-3xl font-black text-surface-900 tracking-tight">Відгуки покупців</h2>
                    <div class="px-3 py-1 bg-white border border-surface-200 rounded-lg text-sm font-bold text-surface-500">{{ reviews.length }}</div>
                </div>

                <div v-if="reviews.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="review in reviews"
                        :key="review.id"
                        class="bg-white/70 backdrop-blur-xl border border-white p-6 rounded-[2rem] shadow-lg shadow-surface-200/50 hover:-translate-y-1 transition-transform duration-300"
                    >
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-100 to-indigo-100 text-brand-700 flex items-center justify-center text-lg font-black shadow-inner">
                                {{ review.user?.name?.charAt(0).toUpperCase() ?? '?' }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-surface-900">{{ review.user?.name ?? 'Анонім' }}</p>
                                <div class="flex text-amber-400 text-sm mt-0.5">
                                    <i v-for="i in 5" :key="i" :class="i <= review.rating ? 'ri-star-fill' : 'ri-star-line'"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-surface-600 leading-relaxed font-medium">{{ review.comment }}</p>
                    </div>
                </div>

                <div v-else class="py-16 text-center text-surface-500 bg-white/40 backdrop-blur-md rounded-[2.5rem] border border-white border-dashed">
                    <i class="ri-chat-smile-3-line text-5xl mb-4 block text-surface-300"></i>
                    <p class="text-lg font-medium">Ще немає відгуків. Будьте першим!</p>
                </div>
            </section>
        </template>
    </div>

    <!-- Review modal -->
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="reviewModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 @click.self="reviewModalOpen = false">
                <div class="absolute inset-0 bg-surface-950/50 backdrop-blur-sm"></div>
                <div class="relative w-full max-w-md card p-6 animate-scale-in">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-semibold text-surface-900">Написати відгук</h2>
                        <button @click="reviewModalOpen = false" class="btn-icon">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>

                    <form @submit.prevent="submitReview" class="space-y-4">
                        <!-- Stars -->
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-2">Оцінка</label>
                            <div class="flex gap-2">
                                <button
                                    v-for="i in 5"
                                    :key="i"
                                    type="button"
                                    @click="reviewForm.rating = i"
                                    :class="['text-2xl transition-colors', i <= reviewForm.rating ? 'text-amber-400' : 'text-surface-200 hover:text-amber-300']"
                                >
                                    <i class="ri-star-fill"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div>
                            <label for="review-comment" class="block text-sm font-medium text-surface-700 mb-1.5">Коментар</label>
                            <textarea
                                id="review-comment"
                                v-model="reviewForm.comment"
                                rows="4"
                                placeholder="Ваш відгук про товар..."
                                class="input resize-none"
                            ></textarea>
                        </div>

                        <button type="submit" :disabled="reviewForm.processing" class="btn-primary w-full justify-center">
                            <i v-if="reviewForm.processing" class="ri-loader-4-line animate-spin"></i>
                            Надіслати відгук
                        </button>
                    </form>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api, { apiData, apiErrors, apiMeta } from '@/shared/api';
import { useCart } from '@/features/cart/add-to-cart';
import { imageUrl, formatPrice } from '@/shared/lib';
import ProductDetailsSkeleton from './ProductDetailsSkeleton.vue';

const props = defineProps({
    id:              { type: [String, Number], default: null },
    product:         { type: Object, default: null },
    characteristics: { type: Object, default: () => ({}) },
    domain:          { type: String, default: '' },
    reviews:         { type: [Array, Object], default: () => [] },
    auth:            { type: Object, default: null },
});

const routeParams = useRoute();
const vueRouter = useRouter();
const { addToCart } = useCart();
const adding = ref(false);
const added = ref(false);
const isLoading = ref(true);
const reviewModalOpen = ref(false);
const product = ref(props.product || {});
const characteristics = ref(props.characteristics || {});
const reviews = ref(props.reviews || []);
const domain = ref(props.domain || import.meta.env.VITE_API_ORIGIN || '');

const sortedImages = computed(() => {
    if (!product.value.images?.length) return [];
    return [...product.value.images].sort((a, b) => (b.is_main ? 1 : 0) - (a.is_main ? 1 : 0));
});

const activeImage = ref(null);

const fetchProduct = async () => {
    isLoading.value = true;

    try {
        const productId = props.id || routeParams.params.id;
        const response = await api.get(`/products/${productId}`);
        const meta = apiMeta(response);
        product.value = apiData(response, {});
        characteristics.value = meta.characteristics || {};
        reviews.value = product.value.reviews || [];
        domain.value = import.meta.env.VITE_API_ORIGIN || '';
        activeImage.value = sortedImages.value[0] ?? null;
    } finally {
        isLoading.value = false;
    }
};

const handleAddToCart = () => {
    if (adding.value || added.value) return;
    adding.value = true;
    addToCart(product.value.id, () => {
        adding.value = false;
        added.value = true;
        setTimeout(() => { added.value = false; }, 2000);
    });
};

const buyNow = () => {
    addToCart(product.value.id, () => vueRouter.push('/checkout'));
};

const reviewForm = reactive({ rating: 5, comment: '', processing: false, errors: {} });

const submitReview = async () => {
    reviewForm.processing = true;
    reviewForm.errors = {};

    try {
        const response = await api.post(`/products/${product.value.id}/reviews`, {
            rating: reviewForm.rating,
            comment: reviewForm.comment,
        });
        reviews.value = [apiData(response), ...reviews.value];
        reviewModalOpen.value = false;
        reviewForm.rating = 5;
        reviewForm.comment = '';
    } catch (error) {
        reviewForm.errors = apiErrors(error);
    } finally {
        reviewForm.processing = false;
    }
};

onMounted(fetchProduct);
</script>

<style scoped>
.modal-enter-active, .modal-leave-active { transition: opacity 0.2s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
</style>
