import wordApi from "@/api/wordApi";
import { useLocalStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { useFilterStore } from "./filterStore";
import { router } from '@inertiajs/vue3';
import { ref } from "vue";

export const useWordStore = defineStore('word', () => {
    // Sync the setting object with localStorage using useLocalStorage
    const setting = useLocalStorage('word-settings', {
        listMode: 'normal', // Default value if nothing is in localStorage
        irregularVerbListMode: 'normal',
        perPage: 100,
    });

    const isGenerating = ref<boolean>(false);

    const unlock = async (ids: number[]) => {
        try {
            isGenerating.value = true;
            const { data } = await wordApi.unlock({ ids });
            if (data?.success) {
                if (filterStore.hasFilter) {
                    filterStore.applyFilters();
                } else {
                    refresh();
                }                
            }
            isGenerating.value = false;
        } catch(err) {
            isGenerating.value = false;
            console.log(err);
        }
    }

    const filterStore = useFilterStore();

    const refresh = () => {
        filterStore.resetFilters();
        isGenerating.value = false;
        router.get(route('word.index', {
            listMode: setting.value.listMode,
            perPage: setting.value.perPage,
        }));
    }

    return { setting, isGenerating, unlock, refresh }
});
