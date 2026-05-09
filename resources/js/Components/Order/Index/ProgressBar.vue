<template>
    <div class="flex items-center w-full mb-8">
        <template v-for="(step, index) in steps" :key="step.name">
            <!-- Step icon -->
            <div class="relative flex flex-col items-center group">
                <div :class="[
                    'flex items-center justify-center w-12 h-12 rounded-2xl transition-colors duration-300 shadow-sm relative z-10',
                    getStepClass(index)
                ]">
                    <i :class="step.icon + ' text-xl'"></i>
                </div>
                <!-- Label -->
                <span :class="[
                    'absolute top-14 text-xs font-medium whitespace-nowrap transition-colors duration-300',
                    index <= getCurrentStep() ? 'text-brand-700' : 'text-surface-400'
                ]">
                    {{ step.label }}
                </span>
            </div>

            <!-- Progress line -->
            <div v-if="index < steps.length - 1" class="flex-1 h-1.5 mx-2 rounded-full bg-surface-100 overflow-hidden relative z-0">
                <div
                    class="h-full bg-brand-500 transition-all duration-500 ease-in-out"
                    :style="{ width: getProgressWidth(index) }"
                ></div>
            </div>
        </template>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    contactInfo:  { type: Boolean, required: true },
    addAddress:   { type: Boolean, required: true },
    confirmOrder: { type: Boolean, required: true },
});

const steps = [
    { name: 'contactInfo',  icon: 'ri-user-line',      label: 'Контакти' },
    { name: 'addAddress',   icon: 'ri-map-pin-line',   label: 'Доставка' },
    { name: 'confirmOrder', icon: 'ri-check-line',     label: 'Підтвердження' },
];

const getCurrentStep = () => {
    if (props.confirmOrder) return 2;
    if (props.addAddress)   return 1;
    if (props.contactInfo)  return 0;
    return -1;
};

const getStepClass = (index) => {
    const current = getCurrentStep();
    if (index < current) return 'bg-brand-500 text-white shadow-brand-500/30';
    if (index === current) return 'bg-brand-50 text-brand-600 border-2 border-brand-500 shadow-brand-500/20';
    return 'bg-white text-surface-400 border border-surface-200';
};

const getProgressWidth = (index) => {
    const current = getCurrentStep();
    if (index < current) return '100%';
    if (index === current) return '50%';
    return '0%';
};
</script>
