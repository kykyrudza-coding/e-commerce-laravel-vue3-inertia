<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
        </label>
        <div class="relative">
            <select
                :id="id"
                :value="modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
                class="block w-full bg-white border border-gray-300 text-gray-900 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
            >
                <option v-if="placeholder" value="" disabled selected>{{ placeholder }}</option>
                <option
                    v-for="option in options"
                    :value="option.name"
                >
                    {{ option.name }}
                </option>
            </select>
        </div>

        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: 'SelectInput',
    props: {
        modelValue: {
            type: [String, Number],
            default: ''
        },
        id: {
            type: String,
            required: true
        },
        options: {
            type: Object,
            required: true
        },
        placeholder: {
            type: String,
            default: 'Выберите значение'
        },
        label: {
            type: String,
            default: ''
        },
        error: {
            type: String,
            default: ''
        },
    }
}
</script>

<style scoped>
select:invalid {
    color: gray;
}
</style>
