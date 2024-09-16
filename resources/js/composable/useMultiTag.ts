import tagApi from "@/api/tagApi";
import { ref } from "vue";
import { TagModel } from '@/types/models/tag.types';
import { useDebounceFn } from "@vueuse/core";

interface TagState {
    isVisible: boolean,
    isLoading: boolean,
    selectedTags: TagModel[],
}

type Tags = Record<string, TagState>;

export default function useMultiTag() {
    const tags = ref<Tags>({});
    const tagSuggestions = ref<TagModel[]>([]);
    const isLoading = ref<boolean>(false);

    const searchTags = useDebounceFn(async (event: any, wordId: number) => {
        const tag = tags.value[getTagName(wordId)];
        tag.isLoading = true;

        const payload = {
            search: event.value
        };

        try {
            const { data } = await tagApi.searchTags(payload);
            tagSuggestions.value = data;
        } catch (error) {
            tag.isLoading = false;
            console.log(error);
            return '';
        }
    }, 300); // Adjust the debounce time (300ms here)

    const getTagName = (wordId: number): string => {
        return `tags-for-${wordId}`;
    }

    const initTagState = (wordId: number, wordTags?: TagModel[]) => {
        tags.value[getTagName(wordId)] = {
            isLoading: false,
            isVisible: false,
            selectedTags: wordTags ?? []
        }
    }

    // Add tags to a word or sentence
    const addTag = async (wordId: number) => {
        const tag = tags.value[getTagName(wordId)];
        const payload = {
            'wordId': wordId,
            'tagsId': tag.selectedTags.map(t => t.id)
        };

        try {
            // Call the API to add tags
            const response = await tagApi.addTagToWord(payload);

            // Optionally update tagView with the new tags if needed
            tag.isLoading = false;
            tag.isVisible = true;

            return response.data;  // Return the response if needed
        } catch (error) {
            console.error('Error adding tags:', error);
            throw error;  // Re-throw the error to handle it in the UI
        }
    };

    // Remove tags from a word or sentence
    const removeTag = async (wordId: number, tagsId: number[] | null = []) => {
        console.log('=============> Remove: ', tagsId)
        const tag = tags.value[getTagName(wordId)];
        let tagToRemove;
        if (tagsId && tagsId?.length > 0) {
            tagToRemove = [...tagsId];
        } else {
            tagToRemove = tag.selectedTags.map((t) => t.id)
            console.log('==========> Else', tagToRemove);
        }

        console.log('=====> Tag to remove; ', tagToRemove)
        const payload = {
            'wordId': wordId,
            'tagsId': tagToRemove
        };

        console.log('=====> ', payload)

        try {
            // Call the API to remove tags
            const response = await tagApi.removeTagFromWord(payload);

            // Optionally update tagView to mark tags as inactive
            tag.isLoading = false;
            tag.isVisible = false;

            return response.data;  // Return the response if needed
        } catch (error) {
            console.error('Error removing tags:', error);
            throw error;  // Re-throw the error to handle it in the UI
        }
    };

    // const clearTags = (wordId: number) => {
    //     const tag = tags.value[getTagName(wordId)];
    //     if (tag) {
    //         tag.selectedTags = [];  // Reset selected tags to an empty array
    //     }
    // };

    return { tags, tagSuggestions, initTagState, addTag, removeTag, searchTags, getTagName }
}
