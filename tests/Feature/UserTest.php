<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Tests\Feature\LoginTest;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_user_can_register_with_valid_data(): void
    {
        $user = User::select('id')->where('email', 'john@doe.com')->first();

        if ($user){
            $user->delete();
        }


        $response = $this->postJson('api/register', [
            'data' => [
                'attributes' => [
                    'name' => 'John Doe',
                    'email' => 'john@doe.com',
                    'password' => 'password',
                ]
            ]
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'john@doe.com',
        ]);

        //dd($response);
        $response->assertJsonStructure([
                "type",
                "id",
                "attributes" => [
                    "name",
                    "username",
                    "email",
                    "avatar",
                ],
                "links" => [
                    "self",
                ],
        ]);
    }

    public function test_user_can_not_register_with_invalid_data(): void
    {
        $response = $this->postJson('api/register', [
            'data' => [
                'attributes' => [
                    'name' => 'name',
                    'email' => 'emial@example.com',
                ]
            ]
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "errors" => [
                [
                    "status",
                    "message",
                    "source",
                ]
            ]
        ]);


    }

    public function getUsuario(): \Tests\Feature\LoginTest
    {
        return new LoginTest(new User);
    }

    public function test_user_can_request_password_reset_with_valid_email()
    {
        //TODO Evitar envio real do email.
        $user = $this->getUsuario();

        $response = $this->postJson('/api/password/forgot', [
            'email' => $user->getUser()->email,
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_not_request_password_reset_with_invalid_email()
    {
        $user = $this->getUsuario();

        $response = $this->postJson('/api/password/forgot', [
           'email' => 'example@example.com',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            "errors" => [
                [
                    "status" => 422,
                    "message" => "The selected email is invalid.",
                    "source" => "email"
                ]
            ]
        ]);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        $user = $this->getUsuario()->getUser();

        $token = Password::createToken($user);

        $response = $this->postJson('/api/password/reset', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        //dd($response);

        $response->assertStatus(200);

        $response->assertJson([
            "data" => [],
            "message" => "Password reset successfully.",
            "status" => 200,
        ]);

        $this->assertTrue(auth()->attempt([
            'email' => $user->email,
            'password' => 'password',
        ]));

    }

    public function test_user_can_not_reset_password_with_invalid_token()
    {
        $user = $this->getUsuario()->getUser();

        $response = $this->postJson('/api/password/reset', [
            'email' => $user->email,
            'token' => '$token',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(400);

        $response->assertJson([
            "message" => "Password reset failed.",
            "status" => 400,
        ]);

    }
}
