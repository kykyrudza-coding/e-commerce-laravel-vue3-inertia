<template>
    <RouterLink :to="route(href)">
        <button type='button' class='py-2.5 px-6 text-sm bg-indigo-500 text-white rounded-lg cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-indigo-700'>
            {{ text }}
            <i class="ri-arrow-right-line"></i>
        </button>
    </RouterLink>
</template>

<script>
export default {
    name: "PromotionCarouselButton",
        props:{
        href: {
            required: true
        },
        text: {
            required: true
        },
    }
}
</script>
