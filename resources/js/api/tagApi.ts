import { AxiosResponse } from "axios";
import { Api } from "./Api";
import { TagModel } from "@/types/models/tag.types";

export default {
    async searchTags(payload: { search: string }): Promise<AxiosResponse<TagModel[]>> {
        try {
            return await Api.post('api/tags', payload);
        } catch (error) {
            throw error;
        }
    },
    async addTagToWord(payload: { 'wordId': number, 'tagsId': number[] }) {
        try {
            return await Api.post('api/tags/word-or-sentence/attach', payload);
        } catch (error) {
            throw error;
        }
    },
    async removeTagFromWord(payload: { 'wordId': number, 'tagsId': number[] }) {
        try {
            return await Api.post('api/tags/word-or-sentence/remove', payload);
        } catch (error) {
            throw error;
        }
    }
}
