<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WordOrSentence;

class WordOrSentencePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    /**
     * Determine if the given word or sentence can be updated by the user.
     */
    function updateWord(User $user, WordOrSentence $word)
    {
        // Allow the update only if the user is the creator
        if ($user->id === $word->user_id || $user->is_admin) {
            return true; // Successfully removed
        }
        return false;
    }

    function modify(User $user, WordOrSentence $word)
    {
        // Allow the update only if the user is the creator
        if ($user->id === $word->user_id || $user->is_admin) {
            return true; // Successfully removed
        }
        return false;
    }

    /**
     * Add a tag to the user's word.
     */
    public function addTagToWord(User $user, WordOrSentence $word): bool
    {
        // Check if the user owns the word or is an admin
        if (($user->id === $word->user_id) || $user->is_admin) {
            return true;
        }
        return false;
    }

    /**
     * Remove a tag from the user's word.
     */
    function removeTagFromWord(User $user, WordOrSentence $word): bool
    {
        // Check if the user owns the word or is an admin
        if ($user->id === $word->user_id || $user->is_admin) {
            return true; // Successfully removed
        }
        return false;
    }
}
