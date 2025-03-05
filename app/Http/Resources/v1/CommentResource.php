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
            'data' => [
                'type' => 'comments',
                'id' => $this->id,
                'attributes' => array_merge([
                    'author_id' => $this->author_id,
                    'post_id' => $this->post_id,
                    'comment' => $this->comment,
                    'image' => $this->image,
                    ], $this->mergeWhen($request->routeIs('comments.show'),
                    [
                        'createdAt' => $this->created_at,
                        'updatedAt' => $this->updated_at,
                    ])),
                'links' => [
                    'self' => route('comments.show', ['comments' => $this->id])
                ]
            ]
        ];
    }
}
