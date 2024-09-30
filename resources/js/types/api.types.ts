import { AxiosResponse } from "axios";
import { PaginatedIrregularVerbs } from "./pagination.types";

export type VerbResponse = Promise<AxiosResponse<PaginatedIrregularVerbs> | void>;

