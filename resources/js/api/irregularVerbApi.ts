import { Api } from "./Api";
import { VerbResponse } from "@/types/api.types";
import { ListMode } from "@/types/words/word.types";

export default {
    async list(page: number, perPage = 100, listMode: ListMode = 'normal'): VerbResponse {
        const params: { per_page: number, page: number, list_mode: ListMode } = {
            per_page: perPage,
            page: page,
            list_mode: listMode,
        }
        try {
            return await Api.get('api/irregular-verbs', { params });
        } catch (error) {
            throw error;
        }
    },
}
