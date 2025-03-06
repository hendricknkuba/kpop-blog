<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function include(string $relationship): bool
    {
        $param = request()->get('include');

        if (!asset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}