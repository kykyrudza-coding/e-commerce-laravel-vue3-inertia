<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="[baseClass, variantClass, sizeClass, block && 'w-full', center && 'justify-center']"
    >
        <i v-if="loading" class="ri-loader-4-line animate-spin"></i>
        <slot name="icon" v-else />
        <slot />
        <slot name="trailing" />
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: { type: String, default: 'button' },
    variant: { type: String, default: 'primary' },
    size: { type: String, default: 'md' },
    block: { type: Boolean, default: false },
    center: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    loading: { type: Boolean, default: false },
});

const baseClass = 'inline-flex items-center gap-2 font-bold transition-all disabled:opacity-70 disabled:cursor-not-allowed';

const variantClass = computed(() => ({
    primary: 'btn-primary',
    secondary: 'btn-secondary',
    ghost: 'btn-ghost',
    danger: 'btn-danger',
    icon: 'btn-icon',
}[props.variant] ?? props.variant));

const sizeClass = computed(() => ({
    sm: 'btn-sm',
    md: '',
    lg: 'btn-lg',
}[props.size] ?? props.size));
</script>
