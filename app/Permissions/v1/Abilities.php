<?php

namespace App\Permissions\v1;

use App\Models\User;

final class Abilities {

    //Post Abilities
    public const CreatePost = 'post:create';
    public const CreateOwnPost = 'post:createOwnPost';
    public const UpdatePost = 'post:update';
    public const UpdateOwnPost = 'post:updateOwn';
    public const DeletePost = 'post:delete';
    public const DeleteOwnPost = 'post:deleteOwn';
    public const ReplacePost = 'post:replace';
    public const ReplaceOwnPost = 'post:replaceOwn';

    //User Abilities
    public const UpdateUser = 'user:update';
    public const UpdateOwnUser = 'user:updateOwn';
    public const DeleteOwnUser = 'user:deleteOwn';
    public const DeleteUser = 'user:delete';
    public const ReplaceUser = 'user:replace';
    public const ReplaceOwnUser = 'user:updateOwn';

    public static function getAbilities(User $user): array
    {
        if ($user->role === 'admin') {
            return [
                self::CreatePost,
                self::CreateOwnPost,
                self::UpdatePost,
                self::UpdateOwnPost,
                self::DeletePost,
                self::DeleteOwnPost,
                self::UpdateUser,
                self::UpdateOwnUser,
                self::DeleteOwnUser,
                self::DeleteUser,
                self::ReplaceUser,
                self::ReplaceOwnUser,
                self::ReplacePost,
                self::ReplaceOwnPost,
            ];
        } else {
            return [
                self::CreateOwnPost,
                self::UpdateOwnPost,
                self::DeleteOwnPost,
                self::UpdateOwnUser,
                self::DeleteOwnUser,
                self::ReplaceOwnUser,
                self::ReplaceOwnPost,
            ];
        }
    }


}