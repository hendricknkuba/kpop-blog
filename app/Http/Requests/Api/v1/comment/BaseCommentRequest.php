<?php

namespace App\Http\Requests\Api\v1\comment;


use Illuminate\Foundation\Http\FormRequest;

class BaseCommentRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'data.attributes.author_id' => 'user_id',
            'data.attributes.post_id' => 'post_id',
            'data.attributes.comment' => 'comment',
        ], $otherAttributes);


        $attributesToUpdate = [];

        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }
}