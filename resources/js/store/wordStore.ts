import { useLocalStorage } from "@vueuse/core";
import { defineStore } from "pinia";

export const useWordStore = defineStore('word', () => {
    // Sync the setting object with localStorage using useLocalStorage
    const setting = useLocalStorage('word-settings', {
        listMode: 'normal', // Default value if nothing is in localStorage
        irregularVerbListMode: 'normal',
        perPage: 100,
    });

    return { setting }
});
