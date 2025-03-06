<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /** @test */
    public function user_can_login_with_correct_credentials(): void
    {
        $user = User::inRandomOrder()->first() ?? User::factory();

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

    /** @test */
    public function user_can_not_login_with_invalid_credentials(): void
    {
        $user = User::inRandomOrder()->first() ?? User::factory();

        $response = $this->postJson('/api/login', [
            'login' => $user->username,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }
}
