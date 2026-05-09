<template>
    <article class="relative flex flex-col h-full bg-white/70 backdrop-blur-xl p-4 sm:p-5 rounded-[2rem] border border-white shadow-lg shadow-surface-200/50 hover:border-brand-300 hover:shadow-2xl hover:shadow-brand-500/15 transition-all duration-300 group overflow-hidden">
        <!-- Background Card Glow on Hover -->
        <div class="absolute inset-0 bg-gradient-to-b from-brand-50/0 to-brand-100/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>

        <RouterLink :to="route('products.show', { product_slug: product.slug })" class="block relative z-10 flex-1 flex flex-col">
            <!-- Badges -->
            <div class="absolute top-0 left-0 z-20 flex flex-col gap-2">
                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-black px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-md shadow-red-500/30">
                    <i class="ri-fire-fill mr-1"></i>Хіт
                </span>
            </div>

            <!-- Image -->
            <div class="aspect-square rounded-[1.5rem] bg-white/80 shadow-inner mb-5 p-5 flex items-center justify-center relative overflow-hidden">
                <img
                    v-if="mainImage"
                    :src="imageUrl(domain, mainImage.image_path)"
                    :alt="product.name"
                    class="w-full h-full object-contain group-hover:scale-110 group-hover:-translate-y-2 transition-transform duration-500 mix-blend-multiply drop-shadow-xl"
                    loading="lazy"
                />
                <div v-else class="text-surface-300">
                    <i class="ri-image-2-line text-5xl"></i>
                </div>
                
                <!-- Quick action overlay -->
                <div class="absolute bottom-3 right-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 z-20">
                    <button
                        @click.prevent="handleAddToCart"
                        :disabled="adding"
                        class="w-12 h-12 rounded-2xl bg-white shadow-xl text-surface-600 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-colors"
                        :id="`product-quick-add-${product.id}`"
                        aria-label="В кошик"
                    >
                        <i :class="adding ? 'ri-loader-4-line animate-spin' : 'ri-shopping-bag-3-line'" class="text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Info -->
            <div class="flex-1 flex flex-col relative z-10">
                <div class="flex items-center gap-1 text-amber-400 text-sm mb-2">
                    <i class="ri-star-fill drop-shadow-sm"></i>
                    <i class="ri-star-fill drop-shadow-sm"></i>
                    <i class="ri-star-fill drop-shadow-sm"></i>
                    <i class="ri-star-fill drop-shadow-sm"></i>
                    <i class="ri-star-half-fill drop-shadow-sm"></i>
                    <span class="text-surface-400 text-xs ml-1 font-medium">(4.8)</span>
                </div>
                
                <h3 class="text-base sm:text-lg font-bold text-surface-900 mb-4 line-clamp-2 group-hover:text-brand-600 transition-colors leading-tight">
                    {{ product.name }}
                </h3>
                
                <div class="mt-auto pt-4 flex items-end justify-between border-t border-surface-200/50">
                    <div>
                        <span v-if="product.old_price" class="text-sm text-surface-400 line-through block mb-1 font-medium">{{ formatPrice(product.old_price) }}</span>
                        <span class="text-xl sm:text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-surface-900 to-surface-700 drop-shadow-sm">{{ formatPrice(product.price) }}</span>
                    </div>
                </div>
            </div>
        </RouterLink>
        
        <!-- Add to Cart (Mobile mostly, visible on hover desktop) -->
        <button
            @click="handleAddToCart"
            :disabled="adding"
            class="mt-4 h-12 w-full rounded-xl flex items-center justify-center gap-2 font-bold text-sm transition-all relative z-10"
            :class="added ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-surface-900 text-white hover:bg-brand-600 shadow-lg group-hover:shadow-brand-500/30 group-hover:scale-[1.02]'"
            :id="`product-add-to-cart-${product.id}`"
        >
            <i :class="added ? 'ri-check-line' : adding ? 'ri-loader-4-line animate-spin' : 'ri-shopping-bag-3-line'" class="text-lg"></i>
            {{ added ? 'У кошику' : adding ? 'Додаємо...' : 'Купити' }}
        </button>
    </article>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useCart } from '@/composables/useCart.js';
import { imageUrl, formatPrice } from '@/utils/helpers.js';

const props = defineProps({
    product: { type: Object, required: true },
    domain: { type: String, default: '' },
});

const { addToCart } = useCart();
const adding = ref(false);
const added = ref(false);

const mainImage = computed(() => {
    if (props.product.main_image) return props.product.main_image;
    if (!props.product.images?.length) return null;
    return props.product.images.find((img) => img.is_main) ?? props.product.images[0];
});

const handleAddToCart = () => {
    if (adding.value || added.value) return;
    adding.value = true;

    addToCart(props.product.id, () => {
        adding.value = false;
        added.value = true;
        setTimeout(() => { added.value = false; }, 2000);
    });
};
</script>
