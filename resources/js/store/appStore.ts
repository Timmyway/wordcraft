import { defineStore } from "pinia";
import { ref } from "vue";
import { useCanvasStore } from "./canvasStore";
import { base64ToImage, imageToBase64, safeJsonParse } from "@/helpers/utils";

export const useAppStore = defineStore('application', () => {
    const canvasStore = useCanvasStore();

    const isSaving = ref<boolean>(false);
    const isReady = ref<boolean>(true);

    return { isSaving }
});
