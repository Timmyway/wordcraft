import { AxiosResponse } from "axios";
import { Api } from "./Api";
import { PaginatedIrregularVerbs } from "@/types/pagination.types";
import { VerbResponse } from "@/types/api.types";

export default {
    async list(page: number): VerbResponse {
        try {
            return await Api.get(`api/irregular-verbs?page=${page}`);
        } catch (error) {
            throw error;
        }
    },
}
