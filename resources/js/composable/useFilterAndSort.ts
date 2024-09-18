import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";

export default function useFilterAndSort(routes: { index: string, search: string }) {
    const filters = ref<{ search: string }>({
        search: '',
    });

    const { index: routeIndex, search: routeSearch } = routes;

    const applyFilters = (options = { preserveState: true, preserveScroll: true }) => {
        const payload = {
            search: filters.value.search,
        }
        const { preserveState, preserveScroll } = options;
        router.post(route(`${routeSearch}`), payload, { preserveState, preserveScroll });
    }

    const hasFilter = computed(() => {
        if (filters.value.search.trim() !== '') {
            return true;
        }
        return false;
    });

    const resetFilters = () => {
        filters.value = {
            search: '',
        }
        router.get(route(routeIndex), { preserveState: true, preserveScroll: true });
    }

    return { filters, hasFilter, applyFilters, resetFilters }
}
