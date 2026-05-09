
<template>
    <div class="mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 w-full">
            <div class="slider-box w-full">
                <div class="swiper main-slide-carousel swiper-container relative mb-6">
                    <div class="swiper-wrapper">
                        <div v-for="image in sortedImages" :key="image.id" class="swiper-slide">
                            <div class="block">
                                <img :src="imageUrl(image)" alt="Product image" class="max-lg:mx-auto sm:min-w-96 sm:min-h-96 rounded-2xl object-cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-for-slider">
                    <div class="swiper-wrapper w-full flex justify-between">
                        <div class="swiper-slide thumbs-slide !mr-0" v-for="(image, index) in product.images" :key="index">
                            <img :src="imageUrl(image)" alt="Product thumbnail" class="cursor-pointer h-16 w-16 sm:w-24 sm:h-24 rounded-xl transition-all duration-500 object-cover">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center w-full">
                <div class="pro-detail w-full lg:pl-8 xl:pl-16 max-lg:mx-auto max-lg:mt-8">
                    <div class="flex items-center justify-between gap-6 mb-6">
                        <div class="text">
                            <h2 class="font-manrope font-bold text-xl sm:!text-3xl leading-10 text-gray-900 mb-2">
                                {{ product.name }}
                            </h2>
                        </div>
                    </div>
                    <div class="flex items-center mb-8 gap-y-3">
                        <div class="flex items-center">
                            <h5 class="font-manrope font-semibold text-2xl leading-9 text-indigo-700">
                                ${{ product.price }}
                            </h5>
                        </div>
                    </div>
                    <div class="lg:mb-6 grid sm:grid-cols-3 gap-y-2">
                        <span v-for="(item, key) in characteristics" :key="key" class=' col-span-1 h-10 lg:h-20 text-zinc-950 lg:text-lg text-sm flex items-center font-medium mr-2 lg:py-2 rounded-full'>
                            {{ item.name }}: {{ item.value }}
                        </span>
                    </div>
                    <div class="py-12">
                        <p class="w-full">
                            {{ product.description }}
                        </p>
                    </div>
                    <div class="sm:flex items-center gap-3 sm:mb-6">
                        <div class="flex items-center justify-center w-full sm:w-1/2 rounded-full">
                            <button
                                @click="openModal"
                                class="text-center w-full px-5 py-4 rounded-[100px] bg-indigo-600 flex items-center justify-center font-semibold text-lg text-white shadow-sm shadow-transparent transition-all duration-500 hover:bg-indigo-700 hover:shadow-indigo-300"
                            >
                                Залишити відгук
                            </button>

                            <ReviewModal
                                v-if="isModalOpen"
                                @close="closeModal"
                                :product-id="product.id"
                                :auth="auth"
                            />
                        </div>
                        <button @click="addToCart()" class="group my-5 sm:my-0 py-3 px-5 rounded-full bg-indigo-50 text-indigo-600 font-semibold text-lg flex items-center justify-center w-full sm:w-1/2 gap-2 shadow-sm shadow-transparent transition-all duration-500 hover:shadow-indigo-300 hover:bg-indigo-100">
                            <i class="ri-shopping-cart-line"></i>
                            Додати до корзини
                        </button>
                    </div>
                    <button
                        @click="buyNow()"
                        class="text-center w-full px-5 py-4 rounded-[100px] bg-indigo-600 flex items-center justify-center font-semibold text-lg text-white shadow-sm shadow-transparent transition-all duration-500 hover:bg-indigo-700 hover:shadow-indigo-300">
                        Купити зараз
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ReviewModal from "@/Components/Modals/ReviewModal.vue";
import {router} from "@inertiajs/vue3";
export default {
    name: "ProductSliderSection",
    components: {ReviewModal},
    mounted() {
        this.initSwipers();
    },
    props: {
        product: {
            type: Object,
            required: true,
        },
        domain: {
            type: String,
            required: true,
        },
        characteristics: {
            type: Object,
            required: true,
        },
        auth: {
            type: Object,
            required: true
        }
    },
    computed: {
        $page() {
            return $page
        },
        sortedImages() {
            if (!this.product.images || this.product.images.length === 0) return [];
            return this.product.images.sort((a, b) => {
                return a.is_main ? -1 : b.is_main ? 1 : 0;
            });
        }
    },
    data() {
        return {
            isModalOpen: false
        };
    },
    methods: {
        buyNow() {
            router.post(`/products/${this.product.id}/buy-now`, {}, {
                onSuccess: () => {
                    router.visit('/checkout');
                },
                onError: (error) => {
                    console.error('Ошибка при добавлении товара в корзину:', error);
                }
            });
        },
        imageUrl(image) {
            return `${this.domain}${image.image_path}`;
        },
        initSwipers() {
            this.swiperThumbs = new Swiper(".nav-for-slider", {
                loop: true,
                spaceBetween: 30,
                slidesPerView: 5,
            });

            this.swiper = new Swiper(".main-slide-carousel", {
                slidesPerView: 1,
                thumbs: {
                    swiper: this.swiperThumbs,
                },
            });
        },
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        handleSubmitReview(formData) {
            const productId = this.product.id;

            router.post(`/products/${productId}/review-add`, formData, {
                onSuccess: () => {
                    alert('Отзыв успешно отправлен!');
                    this.closeModal();
                },
                onError: (errors) => {
                    console.error('Ошибка:', errors);
                    alert('Не удалось отправить отзыв');
                }
            });
        },
        async addToCart() {
            try {
                const response = await fetch(`/products/${this.product.id}/add-to-cart`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message);
                } else {
                    console.error('Ошибка при добавлении товара в корзину:', result);
                }
            } catch (error) {
                console.error('Произошла ошибка:', error);
            }
        }
    }
}
</script>

<style scoped>
.nav-for-slider .swiper-slide {
    height: auto;
    width: auto;
    cursor: pointer;
}
.swiper-wrapper {
    height: auto;
}
.nav-for-slider .swiper-slide img {
    border: 2px solid transparent;
    border-radius: 10px;
}
.nav-for-slider .swiper-slide-thumb-active img {
    border-color: rgb(79 70 229);
}
</style>
