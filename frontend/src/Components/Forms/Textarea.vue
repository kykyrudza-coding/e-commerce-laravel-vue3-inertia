<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">
            <slot name="label">{{ label }}</slot>
        </label>

        <textarea
            :id="id"
            :name="name"
            :placeholder="placeholder"
            v-model="localValue"
            :class="[
        'mt-1 block w-full p-3 border rounded-md shadow-sm sm:text-sm',
        error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-green-500 focus:border-green-500'
      ]"
            :rows="rows"
        ></textarea>

        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: 'Textarea',
    props: {
        modelValue: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            required: false
        },
        id: {
            type: String,
            required: false,
            default() {
                return `textarea-${Math.random().toString(36).substr(2, 9)}`;
            }
        },
        placeholder: {
            type: String,
            default: ''
        },
        error: {
            type: String,
            default: ''
        },
        rows: {
            type: Number,
            default: 4
        },
        label: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            localValue: this.modelValue
        };
    },
    watch: {
        localValue(newValue) {
            this.$emit('update:modelValue', newValue);
        },
        modelValue(newValue) {
            if (newValue !== this.localValue) {
                this.localValue = newValue;
            }
        }
    }
};
</script>
