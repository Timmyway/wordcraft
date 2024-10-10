import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { TagModel } from "@/types/models/models.types";

export const useFilterStore = defineStore('filter', () => {
    const filters = ref<{ search: string, tags: TagModel[], letter: string }>({
        search: '',
        tags: [],
        letter: '',
    });

    const applyFilters = (urlOrRouteName = 'word.filter') => {
        const payload = {
            search: filters.value.search,
            tags: filters.value.tags.map(tag => tag.id),
            letter: filters.value.letter,
        }

        // Check if the provided argument is a URL or a route name
        let url;
        if (urlOrRouteName.startsWith('http://') || urlOrRouteName.startsWith('https://')) {
            // It's a full URL
            url = urlOrRouteName;
        } else {
            // It's a route name, construct the URL from it
            url = route(urlOrRouteName);
        }

        router.post(url, payload, { preserveState: true, preserveScroll: true });
    }

    const hasFilter = computed(() => {
        if (filters.value.search.trim() !== '' || filters.value.tags.length > 0 || filters.value.letter !== '') {
            return true;
        }
        return false;
    });

    const resetFilters = () => {
        filters.value = {
            search: '',
            tags: [],
            letter: '',
        }
        router.get(route('word.index'), { preserveState: true, preserveScroll: true });
    }

    const filterByLetter = (letter: string) => {
        if (!letter) return;
        if (filters.value.letter === letter) {
            filters.value.letter = '';
        } else {
            filters.value.letter = letter;
        }
        applyFilters();
    }

    return { filters, hasFilter, applyFilters, resetFilters, filterByLetter }
});
