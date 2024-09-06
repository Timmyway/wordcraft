import { useTextToSpeech } from "@/composable/useTextToSpeech";
import { defineStore } from "pinia";

export const useAudioStore = defineStore('audio', () => {
    const { textToSpeak, isReading, setVoiceLanguage, speak } = useTextToSpeech();

    const readText = (text: string) => {
        textToSpeak.value = text;
        speak();
    }

    return { readText, isReading, setVoiceLanguage }
});
