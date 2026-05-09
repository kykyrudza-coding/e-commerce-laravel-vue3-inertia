<template>
    <RouterLink :to="route(href)">
        <button type='button' class='py-2.5 px-6 text-sm rounded-lg font-semibold text-indigo-500 transition-all duration-500 hover:bg-indigo-100 hover:shadow-xs hover:text-indigo-700'>
            {{ text }}
        </button>
    </RouterLink>
</template>

<script>
import { Link } from '@/services/spaCompat'
export default {
    name: "MainButton",
    components:{
        Link
    },
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
