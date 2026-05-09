<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-brand-950 via-surface-900 to-surface-950">
        <!-- Decorative background -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-brand-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-brand-800/20 blur-3xl"></div>
        </div>

        <!-- Logo -->
        <Link :href="route('home')" class="mb-8 flex items-center gap-2 group">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white shadow-glow group-hover:shadow-glow-lg transition-shadow duration-300">
                <i class="ri-store-2-line text-lg"></i>
            </span>
            <span class="text-xl font-bold text-white tracking-tight">TechStore</span>
        </Link>

        <slot />
    </div>
</template>

<script setup>
</script>
