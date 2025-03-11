<?php

namespace App\Policies\v1;

use App\Models\User;
use App\Permissions\v1\Abilities;

class UserPolicy
{
    public function __construct()
    {
        //
    }

    public function delete(User $authUser, User $user): bool
    {
        if ($authUser->tokenCan(Abilities::DeleteUser)){
            return true;
        }

        if ($authUser->tokenCan(Abilities::DeleteOwnUser)){
            return $authUser->id === $user->id;
        }

        return false;
    }

    public function update(User $authUser, User $user): bool
    {
        if ($authUser->tokenCan(Abilities::UpdateUser)){
            return true;
        }

        if ($authUser->tokenCan(Abilities::UpdateOwnUser)){
            return $authUser->id === $user->id;
        }

        return false;
    }

    public function replace(User $authUser, User $user): bool
    {
        if ($authUser->tokenCan(Abilities::ReplaceUser)){
            return true;
        }

        if ($authUser->tokenCan(Abilities::ReplaceOwnUser)){
            return $authUser->id === $user->id;
        }

        return false;
    }
}