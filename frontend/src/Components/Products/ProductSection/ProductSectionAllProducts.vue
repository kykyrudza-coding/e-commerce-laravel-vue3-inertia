<template>
    <div class="flex items-center justify-between h-14">

        <div class="underline text-lg font-bold leading-tight underline-offset-8 decoration-2 decoration-indigo-600">
            Products - {{ this.getProductCount()}}
        </div>

        <div class="flex items-center gap-x-2">

            <button
                v-if="showFilter"
                type="button"
                @click="toggleFilters"
                class="w-11 h-11 text-xl rounded-lg flex items-center justify-center cursor-pointer transition-all duration-500 hover:text-white hover:bg-red-500"
            >
                <i class="ri-filter-2-line"></i>
            </button>

            <button
                type="button"
                @click="setColumns(2)"
                :class="['w-11 h-11 text-xl rounded-lg flex lg:hidden items-center justify-center cursor-pointer transition-all duration-500',
                   columnCount === 2 ? 'bg-indigo-400 text-white' : 'hover:text-white hover:bg-indigo-400']"
            >
                <i class="ri-layout-grid-line"></i>
            </button>

            <button
                type="button"
                @click="setColumns(3)"
                :class="['w-11 h-11 text-xl rounded-lg flex items-center justify-center cursor-pointer transition-all duration-500',
                   columnCount === 3 ? 'bg-indigo-400 text-white' : 'hover:text-white hover:bg-indigo-400']"
            >
                <i class="ri-layout-grid-2-line"></i>
            </button>

            <button
                type="button"
                @click="setColumns(4)"
                :class="['w-11 h-11 text-xl rounded-lg lg:flex items-center justify-center cursor-pointer hidden transition-all duration-500',
                   columnCount === 4 ? 'bg-indigo-400 text-white' : 'hover:text-white hover:bg-indigo-400']"
            >
                <i class="ri-grid-line"></i>
            </button>

        </div>
    </div>

    <div
        ref="productGrid"
        :class="`w-full mt-5 grid grid-cols-${columnCount}`"
    >
        <div v-for="product in products" >
            <ProductCart :product="product" :domain="domain" />
        </div>
    </div>
</template>

<script>
import ProductCart from "@/Components/Products/ProductCart/ProductCart.vue";

export default {
    name: "ProductList",
    components: { ProductCart },
    props: {
        toggleFilters: Function,
        products: {
            type: Object,
            required: true,
        },
        showFilter: {
            type: Boolean,
        },
        domain: String
    },
    data() {
        return {
            columnCount: 3,
        };
    },
    methods: {
        setColumns(count) {
            this.columnCount = count;
        },
        getProductCount() {
            return Object.keys(this.products).length;
        },
    },
};
</script>

<style scoped>
button {
    transition: all 0.3s ease;
}
button:hover {
    background-color: #4C51BF;
}
</style>
