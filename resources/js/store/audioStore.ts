import { useTextToSpeech } from "@/composable/useTextToSpeech";
import { defineStore } from "pinia";
import { useCanvasStore } from "./canvasStore";

export const useAudioStore = defineStore('audio', () => {
    const canvaStore = useCanvasStore();
    const { isMwTextConfig } = useCanvasConditions();
    const { textToSpeak, isReading, speak, setVoiceLanguage } = useTextToSpeech();

    const readText = () => {
        if (isMwTextConfig(canvaStore.selectedConfig)) {
            textToSpeak.value = canvaStore.selectedConfig.text ?? '';
            speak();
        }
    }

    return { readText, isReading, setVoiceLanguage }
});
