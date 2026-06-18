<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_own_profile(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $user->id);
    }

    public function test_user_cannot_view_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson("/api/v1/users/{$other->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_update_their_own_profile(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson("/api/v1/users/{$user->id}", [
            'name' => 'New Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
        ]);
    }

    public function test_user_cannot_update_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson("/api/v1/users/{$other->id}", [
            'name' => 'Hacked Name',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['name' => 'Hacked Name']);
    }

    public function test_user_cannot_delete_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/v1/users/{$other->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_own_account(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_listing_all_users_route_is_not_available(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(404);
    }
}
