<template>
    <div class="card p-6">
        <h2 class="font-semibold text-surface-900 mb-6">Товари у замовленні</h2>
        <div class="divide-y divide-surface-100">
            <div v-for="product in products" :key="product.id" class="flex items-center gap-4 py-4 first:pt-0">
                <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-surface-100">
                    <img
                        v-if="product.main_image"
                        :src="imageUrl(product.main_image)"
                        alt="product image"
                        class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center text-surface-300">
                        <i class="ri-image-2-line text-xl"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="font-medium text-sm text-surface-800 truncate mb-1">
                        {{ product.name }}
                    </h5>
                    <h6 class="font-semibold text-sm text-brand-600">
                        {{ formatPrice(product.price) }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="pt-5 border-t border-surface-100 flex items-center justify-between mt-2">
            <p class="font-semibold text-surface-900">Разом</p>
            <h5 class="text-xl font-bold text-surface-900">
                {{ formatPrice(totalPrice) }}
            </h5>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { formatPrice } from '@/utils/helpers.js';

const props = defineProps({
    products: { type: Array, required: true },
    domain:   { type: String, required: true },
});

const imageUrl = (main_image) => {
    return main_image?.image_path ? `${props.domain}${main_image.image_path}` : '';
};

const totalPrice = computed(() => {
    return props.products.reduce((total, product) => {
        const quantity = product.quantity ?? 1;
        return total + (product.price * quantity);
    }, 0);
});
</script>
