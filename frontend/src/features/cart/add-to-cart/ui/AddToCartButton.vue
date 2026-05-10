<template>
    <button
        type="button"
        @click.prevent.stop="handleAddToCart"
        :disabled="adding || added"
        :class="buttonClass"
        :id="buttonId"
        :aria-label="ariaLabel"
    >
        <i :class="[iconClass, iconSizeClass]"></i>
        <span v-if="variant === 'full'">{{ buttonText }}</span>
    </button>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useCart } from '../model/useCart.js';

const props = defineProps({
    productId: { type: [String, Number], required: true },
    variant: { type: String, default: 'full' },
});

const emit = defineEmits(['success']);

const { addToCart } = useCart();
const adding = ref(false);
const added = ref(false);

const labels = {
    added: '\u0423 \u043a\u043e\u0448\u0438\u043a\u0443',
    adding: '\u0414\u043e\u0434\u0430\u0454\u043c\u043e...',
    default: '\u041a\u0443\u043f\u0438\u0442\u0438',
    quickAria: '\u0412 \u043a\u043e\u0448\u0438\u043a',
};

const isQuick = computed(() => props.variant === 'quick');

const buttonClass = computed(() => isQuick.value
    ? 'w-12 h-12 rounded-2xl bg-white shadow-xl text-surface-600 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-colors disabled:opacity-70'
    : [
        'mt-4 h-12 w-full rounded-xl flex items-center justify-center gap-2 font-bold text-sm transition-all relative z-10',
        added.value
            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30'
            : 'bg-surface-900 text-white hover:bg-brand-600 shadow-lg group-hover:shadow-brand-500/30 group-hover:scale-[1.02]',
    ]);

const iconClass = computed(() => {
    if (adding.value) return 'ri-loader-4-line animate-spin';
    if (added.value) return isQuick.value ? 'ri-check-line' : 'ri-check-line';
    return 'ri-shopping-bag-3-line';
});

const iconSizeClass = computed(() => isQuick.value ? 'text-xl' : 'text-lg');
const buttonText = computed(() => added.value ? labels.added : adding.value ? labels.adding : labels.default);
const buttonId = computed(() => isQuick.value ? `product-quick-add-${props.productId}` : `product-add-to-cart-${props.productId}`);
const ariaLabel = computed(() => isQuick.value ? labels.quickAria : buttonText.value);

const handleAddToCart = () => {
    if (adding.value || added.value) return;

    adding.value = true;

    addToCart(props.productId, (response) => {
        adding.value = false;
        added.value = true;
        emit('success', response);
        setTimeout(() => { added.value = false; }, 2000);
    });
};
</script>
