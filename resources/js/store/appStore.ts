import { defineStore } from "pinia";
import { ref } from "vue";

export const useAppStore = defineStore('application', () => {

    const isSaving = ref<boolean>(false);
    const isReady = ref<boolean>(true);
    const showModal = ref(false);

    return { isSaving, isReady, showModal }
});
