<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function getUser(){
        $user = User::inRandomOrder()->first();

        if(empty($user->toArray())){
            return User::factory()->create();
        }

        return $user;
    }

    #[Test]
    public function user_can_login_with_correct_credentials(): void
    {
        $user = $this->getUser();

        $response = $this->postJson('/api/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
            'message',
            'status',
        ]);

        $response->assertJsonFragment(['message' => 'Authenticated']);

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function user_can_not_login_with_invalid_credentials(): void
    {
        $user = $this->getUser();

        $response = $this->postJson('/api/login', [
            'login' => $user->username,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }

    #[Test]
    public function user_can_logout_successfully()
    {
        $user = $this->getUser();

        $plainTextToken = $user->createUuidToken('TestToken')->plainTextToken;

        $tokenParts = explode('|', $plainTextToken);
        $token = $tokenParts[1] ?? $tokenParts[0];

        $this->assertDatabaseHas('personal_access_tokens', [
            'token' => hash('sha256', $token)
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200);

        $response->assertJson([
            'data'=> [],
            'message'=> 'Logged out',
            'status'=> 200
        ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }
}
