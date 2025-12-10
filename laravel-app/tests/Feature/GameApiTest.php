<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameApiTest extends TestCase
{
    public function test_guest_cannot_create_game()
    {
        $response = $this->postJson('/api/games', [
            'u_table_id' => 1,
            'users' => [1,2,3,4],
            'scores' => [25000, 25000, 25000, 25000],
        ]);

        $response->assertStatus(401);
    }

    public function test_logged_in_user_can_create_game()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->postJson('/api/games', [
            'u_table_id' => 1,
            'users' => [1,2,3,4],
            'scores' => [25000, 25000, 25000, 25000],
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
    }

}
