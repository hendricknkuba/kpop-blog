<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiStatusTest extends TestCase
{
    /**
     * A basic test example.
     */

    #[Test]
    public function test_the_application_status_is_up(): void
    {
        $response = $this->get('api/v1/health-check');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
        ]);
    }
}
