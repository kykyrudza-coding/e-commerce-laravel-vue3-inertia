<template>
    <p class="flex items-center justify-between border-b py-2 gap-x-3">
        <span class="font-mono text-xl">{{ label }}:</span>
        <span class="text-lg">{{ value }}</span>
    </p>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true
        },
        value: {
            type: String,
            required: true
        }
    }
}
</script>
