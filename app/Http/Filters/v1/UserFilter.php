<?php

namespace App\Http\Filters\v1;

class UserFilter extends QueryFilter
{

    protected $sortable = [
        'name',
        'email',
        'username',
        'role',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];


    public function include($value) {
        return $this->builder->with($value);
    }

    public function id($value){
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function email($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('email', 'like', $likeStr);
    }

    public function name($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function username($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('username', 'like', $likeStr);
    }

    public function role($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('role', 'like', $likeStr);
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