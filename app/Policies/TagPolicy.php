<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

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
    public function update(User $user, Tag $tag): bool
    {
        // Allow only admins to update tags
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the tag.
     */
    public function delete(User $user, Tag $tag): bool
    {
        // Allow only admins to delete tags
        return $user->is_admin;
    }
}
