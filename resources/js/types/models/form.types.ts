export interface CommentForm {
    id?: number;
    comment: string;
}

export interface TagForm {
    id?: number | null;
    name: string;
    tags: string[]; // or tags: Array<{ id: number; name: string }> if each tag is an object
}
