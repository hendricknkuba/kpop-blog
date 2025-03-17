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
                'type' => 'users',
                'id' => $this->id,
                'attributes' => array_merge([
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'avatar' => $this->avatar,
                    ] + array_filter([
                    'role' => $this->when($request->routeIs('users.show'), $this->role),
                    'bio' => $this->when($request->routeIs('users.show'), $this->bio),
                    'createdAt' => $this->when($request->routeIs('users.show'), $this->created_at),
                    'updatedAt' => $this->when($request->routeIs('users.show'), $this->updated_at),
                ])),
                'includes' => PostResource::collection($this->whenLoaded('posts')),
                'links' => [
                    'self' => route('users.show', ['user' => $this->id])
                ]
        ];
    }
}
