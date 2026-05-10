<template>
    <div aria-hidden="true" class="animate-pulse">
        <div class="flex items-center gap-2 mb-8">
            <div class="h-4 w-16 rounded bg-surface-200/80"></div>
            <div class="h-4 w-4 rounded bg-surface-200/80"></div>
            <div class="h-4 w-20 rounded bg-surface-200/80"></div>
            <div class="h-4 w-4 rounded bg-surface-200/80"></div>
            <div class="h-4 w-40 rounded bg-surface-200/80"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
            <div>
                <div class="aspect-square rounded-[2rem] bg-white/70 border border-white shadow-xl shadow-brand-500/5 mb-4 overflow-hidden">
                    <div class="h-full w-full bg-gradient-to-br from-surface-100 via-white to-surface-200"></div>
                </div>

                <div class="flex gap-3 overflow-hidden py-1 px-1">
                    <div v-for="item in 4" :key="item" class="h-20 w-20 flex-shrink-0 rounded-2xl bg-white border border-white shadow-sm"></div>
                </div>
            </div>

            <div>
                <div class="h-11 w-4/5 rounded-2xl bg-surface-200/80 mb-4"></div>
                <div class="h-14 w-56 rounded-2xl bg-brand-100/80 mb-8"></div>

                <div class="space-y-3 mb-8">
                    <div class="h-5 w-full rounded bg-surface-200/80"></div>
                    <div class="h-5 w-11/12 rounded bg-surface-200/80"></div>
                    <div class="h-5 w-2/3 rounded bg-surface-200/80"></div>
                </div>

                <div class="mb-10">
                    <div class="h-6 w-40 rounded bg-surface-200/80 mb-4"></div>
                    <div class="rounded-[2rem] bg-white/70 border border-white shadow-lg shadow-surface-200/50 overflow-hidden">
                        <div v-for="item in 4" :key="item" class="flex items-center justify-between px-6 py-4 border-b border-surface-200/50 last:border-b-0">
                            <div class="h-4 w-28 rounded bg-surface-200/80"></div>
                            <div class="h-4 w-36 rounded bg-surface-200/80"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <div class="h-16 flex-1 rounded-2xl bg-white border border-brand-100 shadow-lg shadow-brand-500/10"></div>
                    <div class="h-16 flex-1 rounded-2xl bg-brand-200/80 shadow-xl shadow-brand-500/20"></div>
                </div>

                <div class="h-14 w-full rounded-xl bg-surface-100/80"></div>
            </div>
        </div>

        <section class="mt-24">
            <div class="flex items-center gap-3 mb-8">
                <div class="h-9 w-64 rounded-2xl bg-surface-200/80"></div>
                <div class="h-8 w-12 rounded-lg bg-white border border-surface-200"></div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="item in 3" :key="item" class="rounded-[2rem] bg-white/70 border border-white p-6 shadow-lg shadow-surface-200/50">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-12 w-12 rounded-2xl bg-brand-100"></div>
                        <div class="space-y-2">
                            <div class="h-4 w-28 rounded bg-surface-200/80"></div>
                            <div class="h-3 w-20 rounded bg-amber-100"></div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="h-4 w-full rounded bg-surface-200/80"></div>
                        <div class="h-4 w-5/6 rounded bg-surface-200/80"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
