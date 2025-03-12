<?php

namespace App\Http\Filters\v1;

class PostFilter extends QueryFilter
{

    protected $sortable = [
        'title',
        'status',
        'category',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];


    public function include($value) {
        return $this->builder->with($value);
    }

    public function id($value){
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function title($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('title', 'like', $likeStr);
    }

    public function status($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('status', 'like', $likeStr);
    }

    public function category($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('category', 'like', $likeStr);
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