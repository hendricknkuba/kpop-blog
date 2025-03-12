<?php

namespace App\Policies\v1;

use App\Models\Post;
use App\Models\User;
use App\Permissions\v1\Abilities;

class PostPolicy
{
    public function __construct()
    {
        //
    }
    public function create(User $user): bool
    {
        if ($user->tokenCan(Abilities::CreatePost) || $user->tokenCan(Abilities::CreateOwnPost)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->tokenCan(Abilities::DeletePost)){
            return true;
        }

        if ($user->tokenCan(Abilities::DeleteOwnPost)){
            return $user->id === $post->user_id;
        }

        return false;
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->tokenCan(Abilities::UpdatePost)){
            return true;
        }

        if ($user->tokenCan(Abilities::UpdateOwnPost)){
            return $user->id === $user->user_id;
        }

        return false;
    }

    public function replace(User $user, Post $post): bool
    {
        if ($user->tokenCan(Abilities::ReplacePost)){
            return true;
        }

        if ($user->tokenCan(Abilities::ReplaceOwnPost)){
            return $user->id === $user->user_id;
        }

        return false;
    }
}