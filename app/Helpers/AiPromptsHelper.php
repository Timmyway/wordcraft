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
        $prompt = "For the term or question '{$input}', determine whether it is:
        - a single word, phrase, or idiom, or
        - a question (especially FAQ-type).

        If it is a single word, phrase, or idiom:
        - Provide the word/sentence type (e.g., noun, verb, idiom), and ensure all information is presented in English.
        - If the term is a word from another language, provide its equivalent English term, or explain it without using the original word in the examples.
        - If it's an idiom or phrase, explain the meaning in English, avoiding direct translations.
        - Include a detailed English definition, correct pronunciation, at least three example sentences (using the English equivalent if applicable), synonyms, antonyms, and related words.
        - Ensure the response is well-organized, concise, and easy to understand for English learners.

        If the input is phrased as a question, answer it directly in a user-friendly FAQ format:
        - Start by rephrasing the question (if necessary) for clarity.
        - Provide a detailed but easy-to-understand answer with examples if applicable.
        - Ensure the response is structured like a typical FAQ entry, addressing common language learning concerns.
        - Ensure the explanation is tailored for English learners, avoiding overly complex language.
        ";

        return $prompt;
    }
}
