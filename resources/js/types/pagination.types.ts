import { IrregularVerbModel, PlaylistModel, TagModel } from "./models/models.types";
import { WordOrSentence } from "./words/word.types";

export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
    links: PaginationLink[];
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginationSettings {
    perPage: number;
}

export type PaginatedWords = PaginatedResponse<WordOrSentence>;
export type PaginatedTags = PaginatedResponse<TagModel>;
export type PaginatedPlayLists = PaginatedResponse<PlaylistModel>;
export type PaginatedIrregularVerbs = PaginatedResponse<IrregularVerbModel>;
