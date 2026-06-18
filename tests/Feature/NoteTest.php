<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_only_returns_notes_of_authenticated_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Note::factory()->count(2)->create(['user_id' => $user->id]);
        Note::factory()->count(3)->create(['user_id' => $other->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/notes');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_user_can_create_note_owned_by_themselves(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/notes', [
            'title' => 'My note',
            'annotation' => 'Some content',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('notes', [
            'annotation' => 'Some content',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_view_note_of_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $other->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson("/api/v1/notes/{$note->id}");

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_note_of_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $other->id]);

        Sanctum::actingAs($user);

        $response = $this->putJson("/api/v1/notes/{$note->id}", [
            'annotation' => 'Hacked content',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('notes', ['annotation' => 'Hacked content']);
    }

    public function test_user_cannot_delete_note_of_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $other->id]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/v1/notes/{$note->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->putJson("/api/v1/notes/{$note->id}", [
            'annotation' => 'Updated content',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'annotation' => 'Updated content',
        ]);
    }

    public function test_viewing_missing_note_returns_404(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/notes/9999');

        $response->assertStatus(404);
    }
}
