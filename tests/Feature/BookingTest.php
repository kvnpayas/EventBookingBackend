<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
  use RefreshDatabase;

  public function test_customer_can_book_ticket()
  {
    $customer = User::factory()->create(['role' => 'customer']);
    $event = Event::factory()->create();
    $ticket = Ticket::factory()->create(['event_id' => $event->id]);

    $response = $this->actingAs($customer, 'sanctum')->postJson("/api/tickets/{$ticket->id}/booking", [
      'quantity' => 2,
    ]);

    $response->assertStatus(201);
  }
}
