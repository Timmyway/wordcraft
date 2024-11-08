import useMultiTag, { Tags } from "@/composable/useMultiTag";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useWordTagsStore = defineStore('wordTags', () => {
    const wordTags = ref<Tags>({});

    const { initTagState, getTagName, removeTag } = useMultiTag(wordTags.value);

    const getWordTag = (wordId: number) => {
        return wordTags.value?.[getTagName(wordId)];
    }

    return { wordTags, initTagState, getTagName, removeTag, getWordTag }
});
