<template>
    <Head :title="product.name" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-8 flex-wrap">
            <Link :href="route('home')" class="hover:text-surface-600 transition-colors">Головна</Link>
            <i class="ri-arrow-right-s-line"></i>
            <Link :href="route('products.index')" class="hover:text-surface-600 transition-colors">Каталог</Link>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium truncate max-w-xs">{{ product.name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
            <!-- Images -->
            <div>
                <!-- Main image -->
                <div class="aspect-square rounded-2xl overflow-hidden bg-surface-50 mb-3">
                    <img
                        v-if="activeImage"
                        :src="imageUrl(domain, activeImage.image_path)"
                        :alt="product.name"
                        class="w-full h-full object-cover transition-opacity duration-300"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                        <i class="ri-image-2-line text-6xl"></i>
                    </div>
                </div>

                <!-- Thumbnails -->
                <div class="flex gap-2 overflow-x-auto scrollbar-hide">
                    <button
                        v-for="img in sortedImages"
                        :key="img.id"
                        @click="activeImage = img"
                        :class="[
                            'flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition-all duration-200',
                            activeImage?.id === img.id ? 'border-brand-500 shadow-sm' : 'border-surface-200 hover:border-surface-300'
                        ]"
                    >
                        <img :src="imageUrl(domain, img.image_path)" :alt="product.name" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>

            <!-- Product info -->
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-surface-900 mb-3">{{ product.name }}</h1>

                <!-- Price -->
                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-bold text-brand-600">{{ formatPrice(product.price) }}</span>
                </div>

                <!-- Description -->
                <p class="text-surface-600 leading-relaxed mb-6">{{ product.description }}</p>

                <!-- Characteristics -->
                <div v-if="Object.keys(characteristics).length" class="mb-8">
                    <h3 class="text-sm font-semibold text-surface-700 mb-3">Характеристики</h3>
                    <div class="card divide-y divide-surface-100">
                        <div
                            v-for="(item, key) in characteristics"
                            :key="key"
                            class="flex items-center justify-between px-4 py-3 text-sm"
                        >
                            <span class="text-surface-500">{{ item.name }}</span>
                            <span class="font-medium text-surface-800">{{ item.value }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        @click="handleAddToCart"
                        :disabled="adding"
                        class="btn-outline btn-lg flex-1 justify-center"
                        id="product-show-add-cart-btn"
                    >
                        <i :class="adding ? 'ri-loader-4-line animate-spin' : added ? 'ri-check-line' : 'ri-shopping-bag-3-line'"></i>
                        {{ added ? 'Додано!' : adding ? 'Додаємо...' : 'В кошик' }}
                    </button>

                    <button
                        @click="buyNow"
                        class="btn-primary btn-lg flex-1 justify-center"
                        id="product-show-buy-now-btn"
                    >
                        <i class="ri-flash-line"></i>
                        Купити зараз
                    </button>
                </div>

                <!-- Review button -->
                <button
                    @click="reviewModalOpen = true"
                    class="btn-ghost w-full mt-3 justify-center"
                    id="product-show-review-btn"
                >
                    <i class="ri-star-line"></i>
                    Залишити відгук
                </button>
            </div>
        </div>

        <!-- Reviews -->
        <section v-if="reviews" class="mt-16">
            <h2 class="page-title mb-6">Відгуки покупців</h2>

            <div v-if="reviews.length" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="review in reviews"
                    :key="review.id"
                    class="card p-5"
                >
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm font-semibold">
                            {{ review.user?.name?.charAt(0).toUpperCase() ?? '?' }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-surface-800">{{ review.user?.name ?? 'Анонім' }}</p>
                            <div class="flex text-amber-400 text-xs">
                                <i v-for="i in 5" :key="i" :class="i <= review.rating ? 'ri-star-fill' : 'ri-star-line'"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-surface-600 leading-relaxed">{{ review.comment }}</p>
                </div>
            </div>

            <div v-else class="py-12 text-center text-surface-400">
                <i class="ri-chat-3-line text-4xl mb-3 block text-surface-200"></i>
                <p>Ще немає відгуків. Будьте першим!</p>
            </div>
        </section>
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
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { useCart } from '@/composables/useCart.js';
import { imageUrl, formatPrice } from '@/utils/helpers.js';

const props = defineProps({
    product:         { type: Object, required: true },
    characteristics: { type: Object, default: () => ({}) },
    domain:          { type: String, required: true },
    reviews:         { type: [Array, Object], default: () => [] },
    auth:            { type: Object, default: null },
});

const { addToCart } = useCart();
const adding = ref(false);
const added = ref(false);
const reviewModalOpen = ref(false);

const sortedImages = computed(() => {
    if (!props.product.images?.length) return [];
    return [...props.product.images].sort((a, b) => (b.is_main ? 1 : 0) - (a.is_main ? 1 : 0));
});

const activeImage = ref(sortedImages.value[0] ?? null);

const handleAddToCart = () => {
    if (adding.value || added.value) return;
    adding.value = true;
    addToCart(props.product.id, () => {
        adding.value = false;
        added.value = true;
        setTimeout(() => { added.value = false; }, 2000);
    });
};

const buyNow = () => {
    router.post(route('products.buy-now', props.product.id), {}, {
        onSuccess: () => router.visit(route('checkout.index')),
    });
};

const reviewForm = useForm({ rating: 5, comment: '' });

const submitReview = () => {
    reviewForm.post(route('products.review-add', props.product.id), {
        onSuccess: () => {
            reviewModalOpen.value = false;
            reviewForm.reset();
        },
    });
};
</script>

<style scoped>
.modal-enter-active, .modal-leave-active { transition: opacity 0.2s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
</style>
