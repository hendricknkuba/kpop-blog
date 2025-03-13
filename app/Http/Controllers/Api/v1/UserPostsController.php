<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Filters\v1\PostFilter;
use App\Http\Requests\Api\v1\post\ReplacePostRequest;
use App\Http\Requests\Api\v1\post\StorePostRequest;
use App\Http\Requests\Api\v1\post\UpdatePostRequest;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class UserPostsController extends ApiController
{

    public function index($userId, PostFilter $filter)
    {
        return PostResource::collection(Post::where('user_id', $userId)
            ->filter($filter)
            ->paginate());
    }

    public function store(StorePostRequest $request)
    {
        try {
            Gate::authorize('create-post', Post::class);

            return new PostResource(Post::create($request->mappedAttributes()));
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to create that resource.', 403);
        }
    }

    public function update($userId, $postId, UpdatePostRequest $request)
    {
        try {
            $post = Post::where('id', $postId)
                ->where('user_id', $userId)
                ->firstOrFail();

            Gate::authorize('update-post', $post);

            $post->update($request->mappedAttributes());

            return new PostResource($post);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Post not found.', 404);
        } catch (AuthorizationException $exception) {
            return $this->error('Unauthorized to update this post. ', 403);
        }
    }

    public function replace($userId, $postId, ReplacePostRequest $request)
    {
        try {
            $post = Post::where('id', $postId)
                ->where('user_id', $userId)
                ->firstOrFail();

            Gate::authorize('replace-post', $post);

            $post->update($request->mappedAttributes());

            return new PostResource($post);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Post not found.', 404);
        } catch (AuthorizationException $exception) {
            return $this->error('Unauthorized to update this post. ', 403);
        }
    }

    public function destroy($userId, $postId)
    {
        try {
            $post = Post::where('id', $postId)
                ->where('user_id', $userId)
                ->firstOrFail();

            $post->delete();

            return $this->ok('Post deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Post not found.', 404);
        } catch (AuthorizationException $exception) {
            return $this->error('Unauthorized to delete this post. ', 403);
        }
    }
}