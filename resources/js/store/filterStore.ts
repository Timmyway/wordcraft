import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { TagModel } from "@/types/models/models.types";

export const useFilterStore = defineStore('filter', () => {
    const filters = ref<{ search: string, tags: TagModel[] }>({
        search: '',
        tags: [],
    });

    const applyFilters = () => {
        const payload = {
            search: filters.value.search,
            tags: filters.value.tags.map(tag => tag.id),
        }
        router.post(route('word.filter'), payload, { preserveState: true, preserveScroll: true });
    }

    const hasFilter = computed(() => {
        if (filters.value.search.trim() !== '' || filters.value.tags.length > 0) {
            return true;
        }
        return false;
    });

    const resetFilters = () => {
        filters.value = {
            search: '',
            tags: [],
        }
        router.get(route('word.index'), { preserveState: true, preserveScroll: true });
    }

    return { filters, hasFilter, applyFilters, resetFilters }
});
