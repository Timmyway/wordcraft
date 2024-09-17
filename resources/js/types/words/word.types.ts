import { TagModel, CommentModel } from "../models/models.types";

interface User {
    id: number;
    name: string;
    email: string;
}

export interface WordOrSentence {
    id: number;
    word_or_sentence: string;
    about?: string | null;
    image_path: string | null;
    image_url: string | null;
    created_at: string; // Assuming you have timestamps in your model
    updated_at: string; // Assuming you have timestamps in your model
    user: User;
    tags: TagModel[],
    comments: CommentModel[]
}
