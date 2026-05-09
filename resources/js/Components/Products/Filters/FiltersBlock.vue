<template>
    <div class="p-5 lg:p-0">
        <div class="flex items-center justify-between h-14">
            <div class="underline text-lg font-bold leading-tight underline-offset-8 decoration-2 decoration-indigo-600">
                Filters
            </div>
        </div>

        <div class="mt-5">
            <h3 class="font-bold mb-4">Price</h3>
            <div class="mb-4">
                <label class="block mb-2">Min price</label>
                <input type="range" v-model="filters.priceMin" min="0" max="2000" class="w-full" @input="onPriceChange" />
                <label class="block mb-2">Max price</label>
                <input type="range" v-model="filters.priceMax" min="0" max="2000" class="w-full" @input="onPriceChange" />
                <div class="flex items-center justify-center w-full">
                    <input type="text" class="border w-1/2 h-10 p-2 rounded-l" v-model="filters.priceMin" @input="onPriceChange" />
                    <input type="text" class="border w-1/2 h-10 p-2 rounded-r" v-model="filters.priceMax" @input="onPriceChange" />
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="font-bold mb-4">Categories</h3>
            <div v-for="(options, filterKey) in filtersOptions" :key="filterKey" class="mb-4">
                <label :for="filterKey" class="block mb-2 capitalize">{{ filterKey }}</label>
                <select :id="filterKey" v-model="filters[filterKey]" class="w-full h-10 p-2 border rounded" @change="onFilterChange">
                    <option value="">All</option>
                    <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
                </select>
            </div>
        </div>

        <BasicButton type="button" text="Apply Filters" @click="applyFilters" />
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
import BasicButton from "@/Components/Forms/BasicButton.vue";

export default {
    name: "FiltersBlock",
    components: { BasicButton },
    props: {
        filtersOptions: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            filters: {
                priceMin: 0,
                priceMax: 2000,
                deviceType: null,
                brand: null,
                screenSize: null,
                screenType: null,
                os: null,
                processor: null,
                ram: null,
                storage: null,
                cameraResolution: null,
                batteryCapacity: null,
                color: null,
                condition: null,
                availability: null
            }
        };
    },
    watch: {
        filters: {
            handler() {
                this.applyFilters();
            },
            deep: true
        }
    },
    methods: {
        applyFilters() {
            const filtersToApply = {...this.filters};

            Object.keys(filtersToApply).forEach(key => {
                if (filtersToApply[key] === undefined || filtersToApply[key] === null || filtersToApply[key] === '') {
                    delete filtersToApply[key];
                }
            });

            const filterMapping = {
                deviceType: 'deviceType',
                brand: 'brand',
                screenSize: 'screenSize',
                screenType: 'screenType',
                os: 'os',
                processor: 'processor',
                ram: 'ram',
                storage: 'storage',
                cameraResolution: 'cameraResolution',
                batteryCapacity: 'batteryCapacity',
                color: 'color',
                condition: 'condition',
                availability: 'availability',
                priceMin: 'priceMin',
                priceMax: 'priceMax'
            };

            const formattedFilters = {};
            Object.keys(filtersToApply).forEach(key => {
                if (filterMapping[key]) {
                    formattedFilters[filterMapping[key]] = filtersToApply[key];
                }
            });

            router.get(window.location.pathname, formattedFilters, {
                preserveState: true,
                replace: true
            });
        }
    }
};
</script>
