<template>
    <div class="w-full pt-24">
        <!-- headline -->
        <h2 class="font-manrope font-bold text-4xl text-black mb-8 text-center">
            Our customer reviews
        </h2>

        <!-- rating section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-11 pb-11 border-b border-gray-100 ">
            <div class="box flex flex-col col-span-1 gap-y-4 w-full ">

                <div v-for="i in 5" :key="i" class="flex items-center">
                    <p class="font-medium text-lg text-black mr-0.5">
                        {{ i }}
                    </p>
                    <i class="ri-star-s-fill text-amber-400 text-2xl"></i>
                    <p class="h-2 w-full xl:min-w-[278px] rounded-3xl bg-amber-50 ml-5 mr-3">
                        <span
                            class="h-full rounded-3xl bg-amber-400 flex"
                            :style="{ width: getRatingPercentage(i) + '%' }">
                        </span>
                    </p>
                    <p class="font-medium text-lg py-[1px] text-black mr-0.5">
                        {{ getRatingCount(i) }}
                    </p>
                </div>

            </div>

            <div class="p-8 bg-amber-50 col-span-1 rounded-3xl flex items-center justify-center flex-col">
                <h2 class="font-manrope font-bold text-5xl text-amber-400 mb-6">
                    {{ averageRating }}
                </h2>
                <div class="flex items-center justify-center text-5xl text-amber-400 gap-2 sm:gap-6 mb-4">
                    <i v-for="i in 5" :key="i"
                       class="ri-star-s-fill"
                       :class="{ 'text-amber-400': i <= Math.round(averageRating), 'text-gray-300': i > Math.round(averageRating) }">
                    </i>
                </div>
                <p class="font-medium text-xl leading-8 text-gray-900 text-center">
                    {{ totalReviews }} Ratings
                </p>
            </div>
        </div>

        <!-- review section -->
        <div v-for="review in reviews" :key="review.id" class="pt-11 pb-8 border-b border-gray-100 max-xl:max-w-2xl max-xl:mx-auto">
            <div class="flex items-center text-yellow-500 text-3xl gap-3 mb-4">
                <i v-for="i in 5" :key="i"
                   class="ri-star-s-fill"
                   :class="{ 'text-yellow-500': i <= review.rating, 'text-gray-300': i > review.rating }">
                </i>
            </div>
            <div class="flex flex-col min-[400px]:flex-row justify-between gap-5 mb-4">
                <div class="flex items-center gap-3">
                    <h6 class="font-semibold text-lg leading-8 text-indigo-600 ">
                        {{ review.user.name }}
                    </h6>
                </div>
            </div>
            <p class="font-normal text-lg leading-8 text-gray-400 max-xl:text-justify">
                {{ review.review }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductReviewSection",
    props: {
        reviews: {
            type: Array,
            required: true
        }
    },
    computed: {
        averageRating() {
            if (!this.reviews.length) return 0;
            const totalRating = this.reviews.reduce((sum, review) => sum + review.rating, 0);
            return (totalRating / this.reviews.length).toFixed(1);
        },
        totalReviews() {
            return this.reviews.length;
        }
    },
    methods: {
        getRatingCount(rating) {
            return this.reviews.filter(review => review.rating === rating).length;
        },
        getRatingPercentage(rating) {
            const total = this.totalReviews;
            if (!total) return 0;
            const count = this.getRatingCount(rating);
            return ((count / total) * 100).toFixed(2);
        },
    }
}
</script>

