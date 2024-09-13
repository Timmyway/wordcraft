import useMultiTag from "@/composable/useMultiTag";
import { defineStore } from "pinia";

export const useTagStore = defineStore('tag', () => {
    const { tags, tagSuggestions, initTagState, addTag, removeTag, searchTags, getTagName } = useMultiTag();

    return { tags, tagSuggestions, initTagState, addTag, removeTag, searchTags, getTagName }
});
