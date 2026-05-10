import { reactive } from 'vue';
import { RouterLink } from 'vue-router';
import api, { clearAuthToken, setAuthToken } from '@/shared/api';
import appRouter from '@/app/router';

export const Link = RouterLink;

export const Head = {
    props: {
        title: String,
    },
    setup(props) {
        if (props.title) {
            document.title = `${props.title} - TechStore`;
        }

        return () => null;
    },
};

export const pageState = reactive({
    url: window.location.pathname,
    props: {
        auth: {
            user: null,
        },
        cart_count: 0,
        flash: {},
    },
});

export function usePage() {
    return pageState;
}

export async function bootstrapAuth() {
    try {
        const response = await api.get('/user');
        pageState.props.auth.user = response.data.data;
    } catch {
        pageState.props.auth.user = null;
    }
}

export function useForm(initialState = {}) {
    const form = reactive({
        ...initialState,
        processing: false,
        errors: {},
        async post(url, options = {}) {
            return submit('post', url, options);
        },
        async put(url, options = {}) {
            return submit('put', url, options);
        },
        async patch(url, options = {}) {
            return submit('patch', url, options);
        },
        async delete(url, options = {}) {
            return submit('delete', url, options);
        },
        reset() {
            Object.assign(form, initialState);
            form.errors = {};
        },
    });

    async function submit(method, url, options = {}) {
        form.processing = true;
        form.errors = {};

        const payload = Object.fromEntries(
            Object.entries(form).filter(([key, value]) => typeof value !== 'function' && !['processing', 'errors'].includes(key)),
        );

        try {
            const response = method === 'delete'
                ? await api.delete(url)
                : await api[method](url, payload);

            if (response.data?.data && ['/login', '/register'].includes(url)) {
                if (response.data.token) {
                    setAuthToken(response.data.token);
                }

                pageState.props.auth.user = response.data.data;
            }

            if (url === '/logout') {
                clearAuthToken();
                pageState.props.auth.user = null;
            }

            options.onSuccess?.(response);
            return response;
        } catch (error) {
            form.errors = normalizeErrors(error.response?.data?.errors || {});
            options.onError?.(form.errors);
            return error.response;
        } finally {
            form.processing = false;
            options.onFinish?.();
        }
    }

    return form;
}

function normalizeErrors(errors) {
    return Object.fromEntries(
        Object.entries(errors).map(([field, messages]) => [
            field,
            Array.isArray(messages) ? messages[0] : messages,
        ]),
    );
}

export const router = {
    visit(to) {
        return appRouter.push(to);
    },
    get(to, params = {}) {
        return appRouter.push({ path: to, query: params });
    },
    post(url, data = {}, options = {}) {
        return api.post(url, data).then((response) => {
            options.onSuccess?.(response);
            return response;
        });
    },
    put(url, data = {}, options = {}) {
        return api.put(url, data).then((response) => {
            options.onSuccess?.(response);
            return response;
        });
    },
    patch(url, data = {}, options = {}) {
        return api.patch(url, data).then((response) => {
            options.onSuccess?.(response);
            return response;
        });
    },
    delete(url, data = {}, options = {}) {
        return api.delete(url, { data }).then((response) => {
            options.onSuccess?.(response);
            return response;
        });
    },
};
