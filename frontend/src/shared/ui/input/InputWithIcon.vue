<template>
    <div class="relative text-gray-500 focus-within:text-gray-900 mb-5">
        <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
        <div
            :class="[
                'relative',
                'mb-5',
                error ? 'border-red-500' : 'border-gray-300',
            ]"
            class="border"
        >
            <div class="absolute inset-y-0 left-0 flex items-center pt-1 pl-5 text-xl pointer-events-none">
                <slot name="icon"></slot>
            </div>
            <input
                v-bind="$attrs"
                v-model="internalValue"
                :type="type"
                :id="id"
                :name="name"
                required
                class="rounded-full"
                :class="[
                    'block w-full h-11 pr-5 pl-12 py-2.5 text-base font-normal shadow-xs bg-transparent rounded-full placeholder-gray-400 focus:outline-none',
                    error ? 'border-red-500' : 'border-gray-300',
                    error ? 'text-red-500' : 'text-gray-900'
                ]"
                :placeholder="placeholder"
            >
        </div>
    </div>
</template>

<script>
export default {
    name: "InputWithIcon",
    props: {
        id: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        modelValue: {
            type: [String, Number],
            default: ''
        },
        error: {
            type: String,
        }
    },
    data() {
        return {
            internalValue: this.modelValue
        };
    },
    watch: {
        internalValue(newVal) {
            this.$emit('update:modelValue', newVal);
        }
    }
}
</script>

