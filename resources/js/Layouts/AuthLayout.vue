<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-surface-50 relative overflow-hidden">
        <!-- Ambient Background -->
        <div class="fixed inset-0 z-0">
            <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-brand-100/50 via-indigo-50/30 to-transparent"></div>
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-brand-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slow"></div>
            <div class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] bg-indigo-400/20 rounded-full blur-[120px] mix-blend-multiply animate-pulse-slower"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f0a_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f0a_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>
        </div>

        <div class="relative z-10 flex flex-col items-center w-full">
            <!-- Logo -->
            <Link :href="route('home')" class="mb-10 flex items-center gap-3 group animate-slide-up">
                <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 text-white shadow-lg group-hover:shadow-brand-500/30 group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <i class="ri-store-2-fill text-2xl relative z-10"></i>
                </div>
                <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-surface-900 to-surface-700 tracking-tight">TechStore</span>
            </Link>

            <slot />
        </div>
    </div>
</template>

<script setup>
</script>
