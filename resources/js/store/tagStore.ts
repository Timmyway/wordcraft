import useMultiTag, { Tags } from "@/composable/useMultiTag";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useTagStore = defineStore('tag', () => {
    const tags = ref<Tags>();
    const { tagSuggestions, initTagState, addTag, removeTag, searchTags, getTagName } = useMultiTag(tags.value ?? {});

    return { tagSuggestions, initTagState, addTag, removeTag, searchTags, getTagName }
});
