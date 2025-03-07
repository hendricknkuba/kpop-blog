<?php

namespace App\Http\Requests\Api\v1\user;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'data.attributes.name' => 'name',
            'data.attributes.username' => 'username',
            'data.attributes.email' => 'email',
            'data.attributes.password' => 'password',
            'data.attributes.avatar' => 'avatar',
            'data.attributes.role' => 'role',
            'data.attributes.bio' => 'bio',
        ], $otherAttributes);


        $attributesToUpdate = [];

        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {

                $value = $this->input($key);

                if ($attribute === 'password') {
                    $value = bcrypt($value);
                }

                $attributesToUpdate[$attribute] = $value;
            }
        }

        if (!isset($attributesToUpdate['username']) && isset($attributesToUpdate['name'])) {
            $attributesToUpdate['username'] = $this->generateUsername($attributesToUpdate['name']);
        }

        return $attributesToUpdate;
    }

    private function generateUsername(string $name): string
    {
        $baseUsername = strtolower(str_replace(' ', '_', trim($name)));

        do {
            $randomNumber = rand(0, 999);
            $username = $baseUsername . $randomNumber;
        }
        while (User::where('username', $username)->exists());

        return $username;
    }
}