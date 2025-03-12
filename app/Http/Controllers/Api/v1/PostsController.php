<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Filters\v1\PostFilter;
use App\Http\Requests\Api\v1\post\ReplacePostRequest;
use App\Http\Requests\Api\v1\post\StorePostRequest;
use App\Http\Requests\Api\v1\post\UpdatePostRequest;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostsController extends ApiController
{
    public function index(PostFilter $filters)
    {
        return PostResource::collection(Post::filter($filters)->paginate());
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store(User $user, StorePostRequest $request)
    {
        try {

            Gate::authorize('create-post', $user);
            $post = Post::create($request->mappedAttributes());

            return new PostResource($post);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 200);
        }
    }

    public function replace(ReplacePostRequest $request, Post $post)
    {
        try {
            Gate::authorize('replace-post', $post);
            $post->update($request->mappedAttributes());

            return new PostResource($post);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 200);
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            Gate::authorize('update-post', $post);
            $post->update($request->mappedAttributes());

            return new PostResource($post);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 200);
        }
    }

    public function destroy(Post $post)
    {
        try {
            Gate::authorize('delete-post', $post);
            $post->delete();

            return $this->ok('Post deleted.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 200);
        }
    }
}
