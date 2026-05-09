<template>
    <div class="min-h-screen flex flex-col bg-surface-50">
        <AppHeader :auth="$page.props.auth" :cart-count="$page.props.cart_count ?? 0" />

        <main class="flex-1">
            <slot />
        </main>

        <AppFooter />
    </div>
</template>

<script setup>
import AppHeader from '@/Components/Layout/AppHeader.vue';
import AppFooter from '@/Components/Layout/AppFooter.vue';
</script>
