<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_register_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_register_fails_when_password_confirmation_does_not_match(): void
    {
        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('password');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/users/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('status', true)
            ->assertJsonStructure(['data' => ['token', 'user_data']]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/users/login', [
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/v1/users/logout');

        $response->assertStatus(200)
            ->assertJsonPath('status', true);
    }

    public function test_protected_route_requires_authentication(): void
    {
        $response = $this->getJson('/api/v1/notes');

        $response->assertStatus(401);
    }
}
