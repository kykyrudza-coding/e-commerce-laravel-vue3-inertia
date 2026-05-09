import { ref, computed } from 'vue';
import { router } from '@/services/spaCompat';
import axios from 'axios';

const isSearchOpen = ref(false);
const query = ref('');
const results = ref([]);
const loading = ref(false);
let debounceTimer = null;

export function useSearch() {
    const open = () => {
        isSearchOpen.value = true;
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        isSearchOpen.value = false;
        query.value = '';
        results.value = [];
        document.body.style.overflow = '';
    };

    const toggle = () => isSearchOpen.value ? close() : open();

    const search = async () => {
        if (!query.value.trim()) {
            results.value = [];
            return;
        }

        loading.value = true;
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(async () => {
            try {
                const response = await axios.get('/search', { params: { query: query.value } });
                results.value = response.data.results ?? [];
            } catch {
                results.value = [];
            } finally {
                loading.value = false;
            }
        }, 300);
    };

    return {
        isSearchOpen,
        query,
        results,
        loading,
        open,
        close,
        toggle,
        search,
    };
}
