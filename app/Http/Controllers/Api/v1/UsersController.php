<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Filters\v1\UserFilter;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UsersController extends ApiController
{
    public function index(UserFilter $filters)
    {
        return UserResource::collection(User::filter($filters)->paginate());
    }

    public function show(User $user)
    {
        if ($this->include('posts'))
        {
           return new UserResource($user->load('posts'));
        }

        return new UserResource($user);
    }
}
