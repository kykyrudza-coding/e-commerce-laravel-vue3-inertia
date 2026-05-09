import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/Pages/Home/Home.vue';
import ProductsIndex from '@/Pages/Products/ProductsAll.vue';
import ProductShow from '@/Pages/Products/ProductShow.vue';
import CategoryShow from '@/Pages/Category/ShowCategories.vue';
import Cart from '@/Pages/Cart/Index.vue';
import Checkout from '@/Pages/Checkout/CheckoutIndex.vue';
import Login from '@/Pages/Auth/Login.vue';
import Register from '@/Pages/Auth/Register.vue';
import Profile from '@/Pages/User/Profile/Index.vue';
import Orders from '@/Pages/Order/Index.vue';
import About from '@/Pages/About/Index.vue';
import Contact from '@/Pages/Contact/Index.vue';
import Faq from '@/Pages/Faq/Index.vue';
import PaymentSuccess from '@/Pages/Payment/Success.vue';
import PaymentCancel from '@/Pages/Payment/Cancel.vue';
import PaymentError from '@/Pages/Payment/Error.vue';
import { pageState } from '@/services/spaCompat';

const routes = [
    { path: '/', name: 'home', component: Home, meta: { title: 'TechStore' } },
    { path: '/products', name: 'products.index', component: ProductsIndex, meta: { title: 'Catalog' } },
    { path: '/products/:id', name: 'products.show', component: ProductShow, props: true },
    { path: '/categories/:id', name: 'categories.show', component: CategoryShow, props: true },
    { path: '/cart', name: 'cart.index', component: Cart, meta: { title: 'Cart' } },
    { path: '/checkout', name: 'checkout.index', component: Checkout, meta: { title: 'Checkout' } },
    { path: '/orders', name: 'orders.index', component: Orders, meta: { title: 'Orders' } },
    { path: '/login', name: 'login', component: Login, meta: { title: 'Login', layout: 'none' } },
    { path: '/register', name: 'register', component: Register, meta: { title: 'Register', layout: 'none' } },
    { path: '/profile', name: 'profile.index', component: Profile, meta: { title: 'Profile' } },
    { path: '/about', name: 'about', component: About, meta: { title: 'About' } },
    { path: '/contact', name: 'contact', component: Contact, meta: { title: 'Contact' } },
    { path: '/faq', name: 'faq', component: Faq, meta: { title: 'FAQ' } },
    { path: '/payment/success', name: 'payment.success', component: PaymentSuccess, meta: { title: 'Payment success' } },
    { path: '/payment/cancel', name: 'payment.cancel', component: PaymentCancel, meta: { title: 'Payment canceled' } },
    { path: '/payment/error', name: 'payment.error', component: PaymentError, meta: { title: 'Payment error' } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior: () => ({ top: 0 }),
});

router.afterEach((to) => {
    document.title = to.meta.title ? `${to.meta.title} - TechStore` : 'TechStore';
    pageState.url = to.fullPath;
});

export default router;
