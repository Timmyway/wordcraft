import { AxiosResponse } from "axios";
import { Api } from "./Api";
import { PaginatedIrregularVerbs } from "@/types/pagination.types";
import { VerbResponse } from "@/types/api.types";

export default {
    async list(page: number, perPage = 100): VerbResponse {
        const params: { per_page: number, page: number } = {
            per_page: perPage,
            page: page
        }
        try {
            return await Api.get('api/irregular-verbs', { params });
        } catch (error) {
            throw error;
        }
    },
}
