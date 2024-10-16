import { WordOrSentence } from "@/types/words/word.types";

function isLocked(w: WordOrSentence) {
    return !w?.about;
}

export { isLocked }
