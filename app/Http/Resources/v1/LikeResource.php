<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
                'type' => 'likes',
                'id' => $this->id,
                'attributes' => array_merge([
                    'author_id' => $this->author_id,
                    'post_id' => $this->post_id,
                    ], $this->mergeWhen($request->routeIs('likes.show'),
                    [
                        'createdAt' => $this->created_at,
                        'updatedAt' => $this->updated_at,
                    ])),
                'links' => [
                    'self' => route('likes.show', ['likes' => $this->id])
                ]
            ]
        ];
    }
}
