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
        return $user->id === $word->user_id || $user->is_admin;
    }

    function modify(User $user, WordOrSentence $word)
    {
        return $user->id === $word->user_id || $user->is_admin;
    }

    /**
     * Add a tag to the user's word.
     */
    public function addTagToWord(User $user, WordOrSentence $word): bool
    {
        return $user->id === $word->user_id || $user->is_admin;
    }

    /**
     * Remove a tag from the user's word.
     */
    function removeTagFromWord(User $user, WordOrSentence $word): bool
    {
        return $user->id === $word->user_id || $user->is_admin;
    }
}
