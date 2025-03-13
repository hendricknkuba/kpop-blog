<?php

namespace App\Http\Requests\Api\v1\post;


class StorePostRequest extends BasePostRequest
{
    public function authorize(): bool
    {
        //return true;
        // Se o user_id da URL for diferente do author_id do request, retorna falso
        return $this->route('user') == $this->input('data.attributes.author_id', $this->route('user'));
    }

    public function rules(): array
    {
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