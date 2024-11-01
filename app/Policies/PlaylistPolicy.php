<?php

namespace App\Policies;

use App\Helpers\General\LogHelper;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlaylistPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }

    public function create(): bool
    {
        // Allow anyone with an account to create a playlist
        return auth()->check();
    }

    public function update(User $user, Playlist $playlist)
    {
        LogHelper::debug('Debug playlist policy: ', [$user->id, $playlist->user_id]);
        return $user->id === $playlist->user_id;
    }

    public function delete(User $user, Playlist $playlist)
    {
        LogHelper::debug('Debug playlist policy: ', [$user->id, $playlist->user_id]);
        return $user->id === $playlist->user_id;
    }
}
