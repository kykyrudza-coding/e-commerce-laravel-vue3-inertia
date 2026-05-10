<template>
    <ProductCard :product="product" :domain="domain">
        <template #quick-action>
            <AddToCartButton :product-id="product.id" variant="quick" />
        </template>

        <template #footer-action>
            <AddToCartButton :product-id="product.id" />
        </template>
    </ProductCard>
</template>

<script setup>
import { ProductCard } from '@/entities/product';
import { AddToCartButton } from '@/features/cart/add-to-cart';

defineProps({
    product: { type: Object, required: true },
    domain: { type: String, default: '' },
});
</script>
