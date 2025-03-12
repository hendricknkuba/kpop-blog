<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\UserFilter;
use App\Http\Requests\Api\v1\user\ReplaceUserRequest;
use App\Http\Requests\Api\v1\user\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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

    public function update(UpdateUserRequest $request, User $user)
    {
        if (Gate::allows('update-user', $user)){
            $user->update($request->mappedAttributes());
            return new UserResource($user);
        }

        return $this->notAuthorized('You are not authorized to update user.');
    }

    public function replace(ReplaceUserRequest $request, User $user)
    {
        if (!Gate::allows('replace-user', $user)){
            return $this->notAuthorized('You are not authorized to replace user.');
        }

        $user->update($request->mappedAttributes());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        try {
            Gate::authorize('delete-user', $user);

            $user->delete();
            return $this->ok('User deleted.');
        } catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

}
