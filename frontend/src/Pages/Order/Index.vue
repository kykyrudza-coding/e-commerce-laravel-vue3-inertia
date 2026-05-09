<template>
    <Head title="Оформлення замовлення" />

    <div class="container-app py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-surface-400 mb-8">
            <RouterLink :to="route('home')" class="hover:text-surface-600 transition-colors">Головна</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <RouterLink :to="route('cart.index', { user_id: page.props.auth.user?.id || 1 })" class="hover:text-surface-600 transition-colors">Кошик</RouterLink>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-surface-700 font-medium">Оформлення</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main flow area -->
            <div :class="confirmOrder ? 'lg:col-span-3 max-w-3xl mx-auto w-full' : 'lg:col-span-2'">
                <ProgressBar
                    :contactInfo="contactInfo"
                    :addAddress="addAddress"
                    :confirmOrder="confirmOrder"
                />

                <div class="relative min-h-[400px]">
                    <Transition name="fade-slide" mode="out-in">
                        <div v-if="contactInfo" key="contact">
                            <ContactInfoForm :token="token" :errors="errors" :user="user" />
                        </div>
                        <div v-else-if="addAddress" key="address">
                            <AddAddress
                                :errors="errors"
                                :regions="regions"
                                :postOffices="postOffices"
                                :token="token"
                                :cities="cities"
                            />
                        </div>
                        <div v-else-if="confirmOrder" key="confirm">
                            <ConfirmOrder
                                :data="data"
                                :method="method"
                                :user="user"
                                :token="token"
                                :products="products"
                                :domain="domain"
                            />
                        </div>
                    </Transition>
                </div>
            </div>

            <!-- Sticky product summary sidebar -->
            <div v-if="!confirmOrder" class="lg:col-span-1">
                <div class="sticky top-20">
                    <ProductBlock :products="products" :domain="domain" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@/services/spaCompat';
import ProgressBar from '@/Components/Order/Index/ProgressBar.vue';
import ProductBlock from '@/Components/Order/Index/ProductBlock.vue';
import ContactInfoForm from '@/Components/Order/ContactInfo/ContactInfoForm.vue';
import AddAddress from '@/Components/Order/AddAddress/AddAddress.vue';
import ConfirmOrder from '@/Components/Order/ConfirmOrder/ConfirmOrder.vue';

const page = usePage();

defineProps({
    products:     { type: Array, required: true },
    domain:       { type: String, required: true },
    token:        { type: String, required: true },
    errors:       { type: Object, default: () => ({}) },
    contactInfo:  { type: Boolean, required: true },
    addAddress:   { type: Boolean, required: true },
    confirmOrder: { type: Boolean, required: true },
    cities:       { type: Object, default: () => ({}) },
    regions:      { type: Object, default: () => ({}) },
    postOffices:  { type: Object, default: () => ({}) },
    data:         { type: Object, default: () => ({}) },
    method:       { type: Object, default: () => ({}) },
    user:         { type: Object, default: () => ({}) },
});
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateX(20px);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}
</style>
