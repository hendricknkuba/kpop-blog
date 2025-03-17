<?php

namespace App\Http\Resources\v1;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'type' => 'posts',
                'id' => $this->id,
                'attributes' => array_merge([
                    'author_id' => $this->user_id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'image' => $this->image,
                    ] + array_filter(
                    [
                        'slug' => $this->when($request->routeIs('posts.show'), $this->slug),
                        'status' => $this->when($request->routeIs('posts.show'), $this->status),
                        'category' => $this->when($request->routeIs('posts.show'), $this->category),
                        'createdAt' => $this->when($request->routeIs('posts.show'), $this->created_at),
                        'updatedAt' => $this->when($request->routeIs('posts.show'), $this->updated_at),
                    ])),
                'includes' => CommentResource::collection($this->whenLoaded('comments')),
                'links' => [
                    'self' => route('posts.show', ['post' => $this->id])
                ]
        ];
    }
}
