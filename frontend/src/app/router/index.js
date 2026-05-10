import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/pages/home/ui/HomePage.vue';
import ProductsIndex from '@/pages/products/ui/ProductsPage.vue';
import ProductShow from '@/pages/product-details/ui/ProductDetailsPage.vue';
import CategoryShow from '@/pages/category/ui/CategoryPage.vue';
import Cart from '@/pages/cart/ui/CartPage.vue';
import Checkout from '@/pages/checkout/ui/CheckoutPage.vue';
import Login from '@/pages/auth/ui/LoginPage.vue';
import Register from '@/pages/auth/ui/RegisterPage.vue';
import ForgotPassword from '@/pages/auth/ui/ForgotPasswordPage.vue';
import ResetPassword from '@/pages/auth/ui/ResetPasswordPage.vue';
import Profile from '@/pages/profile/ui/ProfilePage.vue';
import Orders from '@/pages/orders/ui/OrdersPage.vue';
import About from '@/pages/about/ui/AboutPage.vue';
import Contact from '@/pages/contact/ui/ContactPage.vue';
import Faq from '@/pages/faq/ui/FaqPage.vue';
import PaymentSuccess from '@/pages/payment/ui/PaymentSuccessPage.vue';
import PaymentCancel from '@/pages/payment/ui/PaymentCancelPage.vue';
import PaymentError from '@/pages/payment/ui/PaymentErrorPage.vue';
import { pageState } from '@/shared/lib/spa-compat';

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
    { path: '/password/reset', name: 'password.request', component: ForgotPassword, meta: { title: 'Password reset', layout: 'none' } },
    { path: '/password/reset/:token', name: 'password.reset', component: ResetPassword, props: (route) => ({ token: route.params.token, email: route.query.email ?? '' }), meta: { title: 'Reset password', layout: 'none' } },
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
