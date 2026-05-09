<template>
    <RouterLink v-if="href" :to="route(href)" class="text-base font-semibold mr-6 group relative w-max">
      <span>
          {{ text }}
      </span>
        <span class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
        <span class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-indigo-600 group-hover:w-3/6"></span>
    </RouterLink>
    <button v-else @click="$emit('click')" class="text-indigo-600 font-semibold pl-3">{{ text }}</button>
</template>

<script>
import { Link } from '@/services/spaCompat';

export default {
    name: "UnderLineLink",
    components: {
        Link
    },
    props: {
        href: {
            type: String,
            default: '',
        },
        text: {
            required: true
        }
    }
}
</script>
