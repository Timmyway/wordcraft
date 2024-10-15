import { AxiosResponse } from "axios";
import { PaginatedIrregularVerbs, PaginatedPlayLists } from "./pagination.types";

export type VerbResponse = Promise<AxiosResponse<PaginatedIrregularVerbs> | void>;
export type PlaylistResponse = Promise<AxiosResponse<PaginatedPlayLists> | void>;

