<?php

namespace App\Http\Requests\Api\v1\user;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ReplaceUserRequest extends BaseUserRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{

       return [
           'data.attributes.name' => 'required|string|max:125|min:3',
           'data.attributes.username' => 'required|string|unique:users,username|max:125|min:3',
           'data.attributes.email' => 'required|string|email|unique:users,email|max:125|min:3',
           'data.attributes.password' => 'required|string|min:6',
           'data.attributes.avatar' => 'nullable|string',
           'data.attributes.role' => 'nullable|string',
           'data.attributes.bio' => 'nullable|string',
        ];
    }
}