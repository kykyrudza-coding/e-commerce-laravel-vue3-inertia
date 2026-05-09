<template>
    <article class="card-hover group overflow-hidden flex flex-col">
        <Link :href="route('products.show', { product_slug: product.slug })" class="block">
            <!-- Image -->
            <div class="relative overflow-hidden bg-surface-50 aspect-square">
                <img
                    v-if="mainImage"
                    :src="imageUrl(domain, mainImage.image_path)"
                    :alt="product.name"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                    <i class="ri-image-2-line text-5xl"></i>
                </div>

                <!-- Badge -->
                <div class="absolute top-3 left-3 flex gap-1.5">
                    <span class="badge-green text-[10px]">
                        <i class="ri-fire-line mr-0.5"></i>
                        Популярне
                    </span>
                </div>

                <!-- Quick action overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-surface-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                    <button
                        @click.prevent="handleAddToCart"
                        :disabled="adding"
                        class="btn-primary btn-sm shadow-lg"
                        :id="`product-add-to-cart-${product.id}`"
                    >
                        <i :class="adding ? 'ri-loader-4-line animate-spin' : 'ri-shopping-bag-3-line'"></i>
                        {{ adding ? 'Додаємо...' : 'В кошик' }}
                    </button>
                </div>
            </div>

            <!-- Info -->
            <div class="p-4 flex-1 flex flex-col">
                <p class="text-xs text-surface-400 mb-1">ID: {{ product.id }}</p>
                <h3 class="text-sm font-medium text-surface-800 leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors duration-200 flex-1">
                    {{ product.name }}
                </h3>
            </div>
        </Link>

        <!-- Price row -->
        <div class="px-4 pb-4 flex items-center justify-between">
            <div>
                <span class="price text-base">{{ formatPrice(product.price) }}</span>
                <span v-if="product.old_price" class="price-old ml-1.5">{{ formatPrice(product.old_price) }}</span>
            </div>
            <button
                @click="handleAddToCart"
                :disabled="adding"
                class="btn-icon text-brand-500 hover:bg-brand-50 hover:text-brand-700"
                :aria-label="`Додати ${product.name} до кошика`"
                :id="`product-cart-icon-${product.id}`"
            >
                <i :class="added ? 'ri-check-line text-emerald-500' : adding ? 'ri-loader-4-line animate-spin' : 'ri-shopping-bag-3-line'" class="text-lg"></i>
            </button>
        </div>
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
