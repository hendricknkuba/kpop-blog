<?php

namespace App\Http\Requests\Api\v1\post;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends BasePostRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{

       return [
           'data.attributes.author_id' => 'sometimes|exists:users,id',
           'data.attributes.title' => 'sometimes|string',
           'data.attributes.content' => 'sometimes|string|max:250',
           'data.attributes.image' => 'nullable|string',
           'data.attributes.slug' => 'sometimes|string',
           'data.attributes.status' => 'nullable|string',
           'data.attributes.category' => 'sometimes|string',
        ];
    }
}