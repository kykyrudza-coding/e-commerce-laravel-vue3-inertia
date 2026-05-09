import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import AppLayout from './Layouts/AppLayout.vue';

createInertiaApp({
    title: (title) => title ? `${title} — TechStore` : 'TechStore',

    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        );

        page.then((module) => {
            // Assign default layout unless the page explicitly opts out (layout: null)
            if (module.default.layout === undefined) {
                module.default.layout = AppLayout;
            }
        });

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Head', Head)
            .component('Link', Link)
            .mixin({ methods: { route: window.route } })
            .mount(el);
    },

    progress: {
        color: '#6366f1',
        showSpinner: false,
    },
});
