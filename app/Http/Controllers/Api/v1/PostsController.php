<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Filters\v1\UserFilter;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class PostsController extends ApiController
{
    public function index(UserFilter $filters)
    {
        //
    }

    public function show(User $user)
    {
        //
    }
}
