<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'type' => 'users',
                'id' => $this->id,
                'attributes' => array_merge([
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'avatar' => $this->avatar,
                    ], $this->mergeWhen($request->routeIs('users.show'),
                    [
                        'role' => $this->role,
                        'bio' => $this->bio,
                        'createdAt' => $this->created_at,
                        'updatedAt' => $this->updated_at,
                    ])),
                'links' => [
                    'self' => route('users.show', ['user' => $this->id])
                ]
            ]
        ];
    }
}
