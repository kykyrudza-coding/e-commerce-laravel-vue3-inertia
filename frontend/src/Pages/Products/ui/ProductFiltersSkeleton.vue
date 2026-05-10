<template>
    <div class="p-5 animate-pulse" aria-hidden="true">
        <div class="flex items-center justify-between mb-6">
            <div class="h-5 w-20 rounded bg-surface-200/80"></div>
            <div class="h-4 w-16 rounded bg-brand-100/80"></div>
        </div>

        <div class="mb-6">
            <div class="h-4 w-14 rounded bg-surface-200/80 mb-3"></div>
            <div class="flex items-center gap-2 mb-3">
                <div class="h-11 flex-1 rounded-xl bg-surface-100"></div>
                <div class="h-3 w-3 rounded bg-surface-200"></div>
                <div class="h-11 flex-1 rounded-xl bg-surface-100"></div>
            </div>
            <div class="h-2 w-full rounded-full bg-surface-100"></div>
        </div>

        <div class="h-px bg-surface-200/70 mb-6"></div>

        <div v-for="item in 5" :key="item" class="mb-5">
            <div class="h-4 w-28 rounded bg-surface-200/80 mb-2"></div>
            <div class="h-11 w-full rounded-xl bg-surface-100"></div>
        </div>

        <div class="h-11 w-full rounded-xl bg-brand-100/80 mt-2"></div>
    </div>
</template>
