const namedRoutes = {
    home: '/',
    faq: '/faq',
    contact: '/contact',
    about: '/about',
    login: '/login',
    'login.store': '/login',
    logout: '/logout',
    register: '/register',
    'register.store': '/register',
    'password.request': '/password/reset',
    'password.email': '/password/email',
    'password.reset': '/password/reset/:id',
    'password.update': '/password/reset',
    'products.index': '/products',
    'products.show': '/products/:id',
    'products.review-add': '/products/:id/reviews',
    'products.buy-now': '/checkout',
    'products.cart_to_checkout': '/checkout',
    'products.delete-from-cart': '/cart',
    'categories.show': '/categories/:id',
    'categories.show.subcategory': '/categories/:id',
    'cart.index': '/cart',
    'checkout.index': '/checkout',
    'checkout.store': '/checkout',
    'orders.index': '/orders',
    'order.index': '/orders',
    'order.store.addAddress': '/orders',
    'profile.index': '/profile',
    'user.update': '/profile',
};

export function route(name, params = {}) {
    let path = namedRoutes[name] || name || '/';

    if (typeof params !== 'object' || params === null) {
        params = { id: params };
    }

    const id = params.id ?? params.product ?? params.product_slug ?? params.category ?? params.category_slug ?? params.subcategory_slug ?? params.user_id;
    path = path.replace(':id', encodeURIComponent(id ?? ''));

    return path;
}
