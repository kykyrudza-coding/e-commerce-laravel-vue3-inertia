
<template>
    <h1 class="font-bold font-mono text-3xl text-center mb-10">
        {{ text }}
    </h1>
</template>

<script>
export default {
    name: "Headline",
    props: {
        text: {
            type: String,
            required: true
        }
    }
}
</script>
