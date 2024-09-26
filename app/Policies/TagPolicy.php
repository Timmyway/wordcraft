<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use App\Models\WordOrSentence;

class TagPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any tags.
     */
    public function viewAny(User $user): bool
    {
        // Allow admins to view all tags
        return $user->is_admin;
    }

    public function modify(User $user): bool
    {
        // Allow admins to view all tags
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create tags.
     */
    public function create(User $user): bool
    {
        // Allow only admins to create tags
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the tag.
     */
    public function update(User $user): bool
    {
        // Allow only admins to update tags
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the tag.
     */
    public function delete(User $user): bool
    {
        // Allow only admins to delete tags
        return $user->is_admin;
    }

    /**
     * Add a tag to the user's word.
     */
    public function addTagToWord(User $user, WordOrSentence $word): bool
    {
        // Check if the user owns the word or is an admin
        if ($user->id === $word->user_id || $user->is_admin) {
            return true;
        }
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
    }
}
