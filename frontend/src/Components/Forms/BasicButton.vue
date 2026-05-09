
<template>
    <button :type="type" class="w-full h-12 bg-indigo-600 hover:bg-indigo-900 rounded-lg transition-all duration-700 shadow-xs text-white text-base font-semibold leading-6">
        {{ text }}
    </button>
</template>

<script>
export default {
    name: "BasicButton",
    props: {
        text: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    }
}
</script>
