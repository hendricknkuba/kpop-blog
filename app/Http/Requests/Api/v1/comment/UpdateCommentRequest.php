<?php

namespace App\Http\Requests\Api\v1\comment;



class UpdateCommentRequest extends BaseCommentRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data.attributes.author_id' => 'required|exists:users,id',
            'data.attributes.post_id' => 'required|exists:posts,id',
            'data.attributes.comment' => 'required|string',
        ];
    }

}