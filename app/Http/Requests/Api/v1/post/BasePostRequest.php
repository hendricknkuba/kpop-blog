<?php

namespace App\Http\Requests\Api\v1\post;


use Illuminate\Foundation\Http\FormRequest;

class BasePostRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'data.attributes.author_id' => 'user_id',
            'data.attributes.title' => 'title',
            'data.attributes.content' => 'content',
            'data.attributes.image' => 'image',
            'data.attributes.slug' => 'slug',
            'data.attributes.status' => 'status',
            'data.attributes.category' => 'category',
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