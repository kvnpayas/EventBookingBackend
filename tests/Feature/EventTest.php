<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
  use RefreshDatabase;

  public function test_organizer_can_create_event()
  {
    $user = User::factory()->create(['role' => 'organizer']);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/events', [
      'title' => 'Concert',
      'description' => 'Music Event',
      'date' => now()->addDays(5),
      'location' => 'Manila'
    ]);

    $response->assertStatus(201)
      ->assertJson([
        'event' => [
          'title' => 'Concert'
        ]
      ]);
  }
}
