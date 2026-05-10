<template>
    <div class="border col-span-1 p-3">
        <RouterLink :to="route('products.show',{product_slug: product.slug})">
            <div class="flex h-7 items-center justify-between text-xs font-medium">
                <span class="flex font-bold gap-x-1 items-center justify-end">
                    <span class="text-zinc-700">
                        Code:
                    </span>
                    {{ product.id }}
                </span>
                <span class="bg-emerald-50 text-emerald-600 border border-emerald-400 px-1.5 py-0.5 rounded-full">
                    Popular
                </span>
            </div>

            <div class="w-full h-60 pt-4">
                <div class="w-full relative h-52">
                    <div class="swiper progress-slide-carousel h-full gap-y-10 swiper-container relative" ref="swiperContainer">
                        <div class="swiper-wrapper max-h-full">
                            <div v-for="image in sortedImages" :key="image.id" class="swiper-slide max-h-52">
                                <div class="block">
                                    <img :src="imageUrl(image)" alt="Product image" class="max-lg:mx-auto rounded-2xl object-cover mx-auto min-h-52 max-h-60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <p class="text-sm">{{ product.name }}</p>
            </div>
        </RouterLink>
        <div class="grid grid-cols-3 my-6 w-full">
            <div class="flex items-center">
                <p class="text-zinc-600 text-sm col-span-1">
                    $ {{ product.price }}
                </p>
            </div>
            <div class="flex col-span-2 gap-x-3 items-center justify-end">
                <button
                    @click="addToCart"
                    type="button"
                    class="w-8 h-8 z-20 text-lg rounded-full flex items-center justify-center cursor-pointer transition-all duration-500 hover:bg-indigo-200"
                >
                    <i class="ri-shopping-cart-line"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import api from '@/shared/api';


export default {
    name: 'ProductTile',
    props: {
        product: {
            type: Object,
            required: true,
        },
        domain: String
    },
    computed: {
        sortedImages() {
            if (!this.product.images || this.product.images.length === 0) return [];
            return this.product.images.sort((a, b) => {
                return a.is_main ? -1 : b.is_main ? 1 : 0;
            });
        }
    },
    methods: {
        imageUrl(image) {
            return `${this.domain}${image.image_path}`;
        },
        async addToCart() {
            try {
                await api.post('/cart/items', { product_id: this.product.id });
            } catch (error) {
                console.error('Произошла ошибка:', error);
            }
        }
    }
};
</script>
