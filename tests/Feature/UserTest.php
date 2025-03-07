<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $response->assertJsonStructure([
            "data" => [
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

            ]
        ]);
    }

    public function test_user_can_not_register_with_invalid_data(): void
    {
        $response = $this->postJson('api/register', [
            'data' => [
                'attributes' => [
                    'name' => 'John Doe',
                    'email' => 'john@doe.com',
                ]
            ]
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            "message",
            "errors" => []
        ]);


    }
}
