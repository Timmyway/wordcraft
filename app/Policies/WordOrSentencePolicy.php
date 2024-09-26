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
        /**
         * Determine if the given word or sentence can be updated by the user.
         */
        function updateWord(User $user, WordOrSentence $word)
        {
            // Allow the update only if the user is the creator
            if ($user->id === $word->user_id || $user->is_admin) {
                return true; // Successfully removed
            }
        }

        function modify(User $user, WordOrSentence $word)
        {
            // Allow the update only if the user is the creator
            if ($user->id === $word->user_id || $user->is_admin) {
                return true; // Successfully removed
            }
        }
    }
}
