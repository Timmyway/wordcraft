import tagApi from "@/api/tagApi";
import { TagModel } from "@/types/models/models.types";

export default function useTagOperation() {

    // Add tags to a word or sentence
    const addTagToWord = async (wordId: number, selectedTags: TagModel[]) => {
        const payload = {
            'wordId': wordId,
            'tagsId': selectedTags.map(t => t.id)
        };

        try {
            // Call the API to add tags
            const response = await tagApi.addTagToWord(payload);
            return response.data;  // Return the response if needed
        } catch (error) {
            console.error('Error adding tags:', error);
            throw error;  // Re-throw the error to handle it in the UI
        }
    };

    // Remove tags from a word or sentence
    const removeTagFromWord = async (wordId: number, tagsId: number[] | null = []) => {
        if (!tagsId) return;

        const payload = {
            'wordId': wordId,
            'tagsId': tagsId
        };

        try {
            // Call the API to remove tags
            const response = await tagApi.removeTagFromWord(payload);

            return response.data;  // Return the response if needed
        } catch (error) {
            console.error('Error removing tags:', error);
            throw error;  // Re-throw the error to handle it in the UI
        }
    };

    // Add tags to multiple words
    const addTagsToWords = async (wordIds: number[], selectedTags: TagModel[]) => {
        const payload = {
            'wordIds': wordIds,
            'tagsId': selectedTags.map(t => t.id),
        };

        try {
            // Call the API to add tags to multiple words
            const response = await tagApi.addTagsToWords(payload);
            return response.data;  // Return the response if needed
        } catch (error) {
            console.error('Error adding tags to words:', error);
            throw error;  // Re-throw the error to handle it in the UI
        }
    };

    return { addTagToWord, removeTagFromWord, addTagsToWords }
}
