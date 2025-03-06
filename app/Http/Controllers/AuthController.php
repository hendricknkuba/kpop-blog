<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Guid\Guid;

class AuthController extends Controller
{
    use ApiResponses;


    public function login(ApiLoginRequest $request)
    {
        $request->validated();

        $loginField = $request->input('login');

        $credentials = filter_var($loginField, FILTER_VALIDATE_EMAIL)
        ? ['email' => $loginField]
        : ['username' => $loginField];

        if(!Auth::attempt(array_merge($credentials, ['password' => $request->input('password')]))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::where($credentials)->first();

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createUuidToken(
                    'API Token',
                )->plainTextToken,
            ]
        );
    }
}