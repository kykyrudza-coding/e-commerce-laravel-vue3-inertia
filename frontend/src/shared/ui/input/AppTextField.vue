<template>
    <div>
        <label v-if="label" :for="id" class="block text-sm font-medium text-surface-700 mb-1.5">
            {{ label }}
        </label>
        <div class="relative">
            <i
                v-if="icon"
                :class="icon"
                class="absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400"
            ></i>
            <input
                v-bind="$attrs"
                :id="id"
                :value="modelValue"
                :type="type"
                :placeholder="placeholder"
                :class="['input', icon && 'pl-10', error && 'input-error']"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>

<script setup>
defineOptions({ inheritAttrs: false });

defineProps({
    id: { type: String, required: true },
    modelValue: { type: [String, Number], default: '' },
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    icon: { type: String, default: '' },
    error: { type: [String, Boolean], default: '' },
});

defineEmits(['update:modelValue']);
</script>
