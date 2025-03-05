<?php

namespace App\Http\Resources\v1;

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
            'data' => [
                'type' => 'posts',
                'id' => $this->id,
                'attributes' => array_merge([
                    'author_id' => $this->author_id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'image' => $this->image,
                    ], $this->mergeWhen($request->routeIs('posts.show'),
                    [
                        'slug' => $this->slug,
                        'status' => $this->status,
                        'category' => $this->category,
                        'createdAt' => $this->created_at,
                        'updatedAt' => $this->updated_at,
                    ])),
                'links' => [
                    'self' => route('posts.show', ['posts' => $this->id])
                ]
            ]
        ];
    }
}
