<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubmitRankingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Seed players
        Player::factory()->count(11)->create();
    }

    public function test_user_can_submit_valid_rankings()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $players = Player::take(11)->get();

        $payload = [
            'rankings' => $players->map(function ($player, $index) {
                return [
                    'player_id' => $player->id,
                    'rank' => $index + 1
                ];
            })->toArray()
        ];

        $response = $this->postJson('/api/submit-rankings', $payload);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Your rankings have been saved.']);

        $this->assertDatabaseCount('user_rankings', 11);
    }

    public function test_it_rejects_duplicate_ranks()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $players = Player::take(11)->get();

        $payload = [
            'rankings' => $players->map(function ($player) {
                return [
                    'player_id' => $player->id,
                    'rank' => 1 // duplicate rank
                ];
            })->toArray()
        ];

        $response = $this->postJson('/api/submit-rankings', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['rankings.0.rank']);
    }
}
