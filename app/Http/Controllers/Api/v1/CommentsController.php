<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\CommentFilter;
use App\Http\Requests\Api\v1\comment\StoreCommentRequest;
use App\Http\Requests\Api\v1\comment\UpdateCommentRequest;
use App\Http\Resources\v1\CommentResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class CommentsController extends ApiController
{
    public function index(CommentFilter $filter)
    {
        return CommentResource::collection(Comment::filter($filter)->paginate());
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function store(StoreCommentRequest $request, User $user)
    {
        try {
            Gate::authorize('create-comment', $user);

            $comment = Comment::create($request->mappedAttributes());
            return new CommentResource($comment);

        } catch (AuthorizationException $e) {
            return $this->error('Unauthorized to create comment.', 403);
        } catch (ModelNotFoundException $e) {
            return $this->error('Comment not found.', 404);
        }
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        try {
            Gate::authorize('update-comment', $comment);

            $comment->update($request->mappedAttributes());

            return new CommentResource($comment);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Comment not found', 404);
        } catch (AuthorizationException $exception) {
            return $this->error('Unauthorized to update this comment.', 403);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            Gate::authorize('delete-comment', $comment);

            $comment->delete();

            return $this->ok('Comment deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Comment not found', 404);
        } catch (AuthorizationException $exception) {
            return $this->error('Unauthorized to delete this comment.', 403);
        }
    }
}