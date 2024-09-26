import { ListMode } from "@/types/words/word.types";
import { useLocalStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useWordStore = defineStore('word', () => {
    // Sync the setting object with localStorage using useLocalStorage
    const setting = useLocalStorage('word-settings', {
        listMode: 'normal', // Default value if nothing is in localStorage
    });

    return { setting }
});
