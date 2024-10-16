import { PlaylistResponse } from "@/types/api.types";
import { defineStore } from "pinia";
import { ref } from "vue";
import { PlaylistModel } from "@/types/models/models.types";
import playlistApi from "@/api/playlistApi";
import { WordOrSentence } from "@/types/words/word.types";

export const usePlaylistStore = defineStore('playlist', () => {

    const playlists = ref<PlaylistModel[]>([]);
    const selected = ref<number | null>(null);

    const fetchPlaylists = async (): PlaylistResponse => {
        try {
            const response = await playlistApi.list();

            // Check if the response is not null before accessing data
            if (response && response.data) {
                playlists.value = response.data; // Assign the data to reactive state
            }
        } catch (error) {
            console.error('Error fetching irregular verbs:', error);
        }
    }

    const clearPlaylist = async (playlistId: number) => {
        if (!playlistId) return;
        try {
            // Call the API method to clear the playlist
            await playlistApi.clearPlaylist(playlistId);
        } catch (error) {
            console.error('Error clearing playlist:', error);
        }
    };

    const reset = () => {
        selected.value = null;
    }

    const addWords = async (wordsId: number[]) => {
        if (selected.value) {
            const payload = {
                words_or_sentences: wordsId,
            }
            const { data } = await playlistApi.addWords(selected.value, payload);
            console.log('==========> Data', data);
        }
    }

    return { playlists, selected, fetchPlaylists, reset, addWords, clearPlaylist }
});
