import irregularVerbApi from "@/api/irregularVerbApi";
import { VerbResponse } from "@/types/api.types";
import { PaginatedIrregularVerbs } from "@/types/pagination.types";
import { AxiosResponse } from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useVerbStore = defineStore('verb', () => {

    const irregularVerbs = ref<PaginatedIrregularVerbs>();

    const getPageFromUrl = (urlString: string) => {
        const url = new URL(urlString);
        const params = new URLSearchParams(url.search);
        const page = params.get('page') || '1'; // If 'page' is null, use '1' as default
        return parseInt(page, 10); // Convert to an integer
    };

    const visit = (urlString: string) => {
        const page = getPageFromUrl(urlString);
        fetchIrregularVerbs(page);
    }

    const fetchIrregularVerbs = async (page = 1): VerbResponse => {
        try {
            const response = await irregularVerbApi.list(page);

            // Check if the response is not null before accessing data
            if (response && response.data) {
                irregularVerbs.value = response.data; // Assign the data to reactive state
                return response; // Return the full response
            }
        } catch (error) {
            console.error('Error fetching irregular verbs:', error);
        }
    }


    return { irregularVerbs, visit, fetchIrregularVerbs }
});
