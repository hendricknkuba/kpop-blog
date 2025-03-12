<?php

namespace App\Http\Requests\Api\v1\post;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ReplacePostRequest extends BasePostRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{

       return [
           'data.attributes.author_id' => 'required|exists:users,id',
           'data.attributes.title' => 'required|string',
           'data.attributes.content' => 'required|string|max:250',
           'data.attributes.image' => 'nullable|string',
           'data.attributes.slug' => 'required|string',
           'data.attributes.status' => 'nullable|string',
           'data.attributes.category' => 'required|string',
        ];
    }
}