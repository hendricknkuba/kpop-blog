<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'type' => 'comments',
                'id' => $this->id,
                'attributes' => array_merge([
                    'author_id' => $this->user_id,
                    'post_id' => $this->post_id,
                    'comment' => $this->comment,
                    'image' => $this->image,
                    ] + array_filter(
                    [
                        'createdAt' => $this->when($request->routeIs('comments.show'), $this->created_at),
                        'updatedAt' => $this->when($request->routeIs('comments.show'), $this->updated_at),
                    ])),
                'links' => [
                    'self' => route('comments.show', ['comment' => $this->id])
                ]
        ];
    }
}
