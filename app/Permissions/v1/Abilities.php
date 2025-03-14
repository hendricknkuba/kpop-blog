<?php

namespace App\Permissions\v1;

use App\Models\User;

final class Abilities {

    //User Abilities
    public const UpdateUser = 'user:update';
    public const UpdateOwnUser = 'user:updateOwn';
    public const DeleteOwnUser = 'user:deleteOwn';
    public const DeleteUser = 'user:delete';
    public const ReplaceUser = 'user:replace';
    public const ReplaceOwnUser = 'user:updateOwn';

    //Post Abilities
    public const CreatePost = 'post:create';
    public const CreateOwnPost = 'post:createOwnPost';
    public const UpdatePost = 'post:update';
    public const UpdateOwnPost = 'post:updateOwn';
    public const DeletePost = 'post:delete';
    public const DeleteOwnPost = 'post:deleteOwn';
    public const ReplacePost = 'post:replace';
    public const ReplaceOwnPost = 'post:replaceOwn';

    //Comment Abilities
    public const CreateComment = 'comment:create';
    public const CreateOwnComment = 'comment:createOwnComment';
    public const UpdateComment = 'comment:update';
    public const UpdateOwnComment = 'comment:updateOwnComment';
    public const DeleteComment = 'comment:delete';
    public const DeleteOwnComment = 'comment:deleteOwn';


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
                self::CreateComment,
                self::CreateOwnComment,
                self::UpdateComment,
                self::UpdateOwnComment,
                self::DeleteComment,
                self::DeleteOwnComment,
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
                self::CreateOwnComment,
                self::UpdateOwnComment,
                self::DeleteOwnComment,
            ];
        }
    }


}