import { User } from "../auth.types";
import { WordOrSentence } from "../words/word.types";

export interface CommentModel {
    id: number;
    comment: string;
    word_or_sentence_id: number;
    user_id: number;
    created_at: string;
    updated_at: string;
    user: User
}

export interface TagModel {
    id: number;
    name: string;
}

export interface PlaylistModel {
    id: number;
    name: string;
    created_at?: string;
    updated_at?: string;
    words_or_sentences?: WordOrSentence[];
}

export interface IrregularVerbModel {
    id: number;
    verb: string;
    past_simple: string;
    past_participle: string;
}
