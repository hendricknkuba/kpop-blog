<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\v1\user\StoreUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use App\Permissions\v1\Abilities;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Mockery\Exception;

class AuthController extends Controller
{
    use ApiResponses;


    public function login(ApiLoginRequest $request): JsonResponse
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
                    Abilities::getAbilities($user),
                )->plainTextToken,
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
            Auth::user()->tokens()->delete();

            return $this->ok('Logged out');
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->mappedAttributes());

            return $this->resource(new UserResource($user));

        } catch (Exception $e){
            return $this->error($e->getMessage(), 200);
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
           'email' => 'required|email|exists:users,email',
        ]);

        Password::sendResetLink($request->only('email'));

        return Password::RESET_LINK_SENT
            ? $this->ok('Reset password link sent.')
            : $this->error('Reset password link failed.', 400);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
          $request->only('email', 'password', 'password_confirmation', 'token'),
          function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
          }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->ok('Password reset successfully.')
            : $this->error('Password reset failed.', 400);
    }

}