<?php
namespace App\Helpers;

class AiPromptsHelper
{
    // Determine whether input is a word or a sentence
    public static function isWord(string $input): bool
    {
        // A simple rule: if there is no space, it's a word
        return str_word_count($input) === 1;
    }

    // Generate prompt for "about" information
    public static function generateAboutPrompt(string $input): string
    {
        $prompt = "For the term '{$input}', provide the word/sentence type (e.g., noun, verb, idiom),
        a detailed definition, correct pronunciation, at least three example sentences illustrating its use,
        synonyms, antonyms, and a few related words. Keep the information well-organized and concise.";

        return $prompt;
    }
}
