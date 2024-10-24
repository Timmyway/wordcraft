import { defineStore } from "pinia";
import { ref } from "vue";

export const useAppStore = defineStore('application', () => {

    const isSaving = ref<boolean>(false);
    const isReady = ref<boolean>(true);
    const showModal = ref(false);

    // Check if the user prefers dark mode
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;

    return { isSaving, isReady, showModal, prefersDarkScheme }
});
