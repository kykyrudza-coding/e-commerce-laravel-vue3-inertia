<template>
    <div
        class="grid gap-4 transition-all duration-300"
        :class="gridClass"
        aria-hidden="true"
    >
        <article
            v-for="item in 6"
            :key="item"
            class="min-h-[360px] rounded-[2rem] bg-white/70 border border-white shadow-lg shadow-surface-200/50 overflow-hidden animate-pulse"
        >
            <div class="aspect-square bg-gradient-to-br from-surface-100 via-white to-surface-200"></div>
            <div class="p-5">
                <div class="h-4 w-3/4 rounded bg-surface-200/80 mb-3"></div>
                <div class="h-4 w-1/2 rounded bg-surface-200/80 mb-5"></div>
                <div class="flex items-end justify-between gap-3">
                    <div class="h-7 w-24 rounded bg-surface-200/80"></div>
                    <div class="h-11 w-11 rounded-2xl bg-brand-100/80"></div>
                </div>
            </div>
        </article>
    </div>
</template>

<script setup>
defineProps({
    gridClass: { type: String, required: true },
});
</script>
