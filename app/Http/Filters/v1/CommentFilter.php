<?php

namespace App\Http\Filters\v1;

class CommentFilter extends QueryFilter
{

    protected $sortable = [
        'id',
        'post_id',
        'user_id',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];


    public function include($value) {
        return $this->builder->with($value);
    }

    public function id($value){
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function postId($value){
        return $this->builder->whereIn('post_id', explode(',', $value));
    }

    public function userId($value){
        return $this->builder->whereIn('user_id', explode(',', $value));
    }

    public function updatedAt($value) {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }

    public function createdAt($value) {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }
}