<?php

namespace App\Policies\v1;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Permissions\v1\Abilities;

class CommentPolicy
{
    public function __construct()
    {
        //
    }
    public function create(User $user): bool
    {
        if ($user->tokenCan(Abilities::CreateComment) || $user->tokenCan(Abilities::CreateOwnComment)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Comment $comment): bool
    {
        if ($user->tokenCan(Abilities::DeleteComment)){
            return true;
        }

        if ($user->tokenCan(Abilities::DeleteOwnComment)){
            return $user->id === $comment->user_id;
        }

        return false;
    }

    public function update(User $user, Comment $comment): bool
    {
        if ($user->tokenCan(Abilities::UpdateComment)){
            return true;
        }

        if ($user->tokenCan(Abilities::UpdateOwnComment)){
            return $user->id === $comment->user_id;
        }

        return false;
    }

}