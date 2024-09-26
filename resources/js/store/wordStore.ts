import { ListMode } from "@/types/words/word.types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useWordStore = defineStore('word', () => {
    const setting = ref<{
        listMode: ListMode
    }> ({
        listMode: 'normal',
    });

    return { setting }
});
