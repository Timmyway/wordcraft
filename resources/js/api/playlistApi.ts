import { AxiosResponse } from "axios";
import { Api } from "./Api";
import { PlaylistModel, TagModel } from "@/types/models/models.types";

export default {
    async list(): Promise<AxiosResponse<PlaylistModel[]>> {
        try {
            return await Api.get('api/playlists');
        } catch (error) {
            throw error;
        }
    },
    async create(payload: { name: string, words_or_sentences?: number[] }) {
        try {
            return await Api.post('api/playlists', payload);
        } catch (error) {
            throw error;
        }
    },
    async update(playlistId: number, payload: { 'name': string }) {
        try {
            return await Api.put(`api/playlists/${playlistId}`, payload);
        } catch (error) {
            throw error;
        }
    },
    async delete(playlistId: number) {
        try {
            return await Api.delete(`api/playlists/${playlistId}`);
        } catch (error) {
            throw error;
        }
    },
    async addWords(playlistId: number, payload: { 'words_or_sentences': number[] }) {
        try {
            return await Api.post(`api/playlists/${playlistId}/add`, payload);
        } catch (error) {
            throw error;
        }
    },
    async removeWords(playlistId: number, payload: { 'words_or_sentences': number[] }) {
        try {
            return await Api.post(`api/playlists/${playlistId}/remove`, payload);
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
    },
    async clearPlaylist(playlistId: number) {
        try {
            return await Api.delete(`api/playlists/${playlistId}/clear`);
        } catch (error) {
            throw error;
        }
    }
}
