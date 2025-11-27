<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_pay_for_booking()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $booking = Booking::factory()->create([
            'user_id' => $customer->id,
            'ticket_id' => $ticket->id,
            'quantity' => 2,
        ]);

        $this->mock(PaymentService::class, function ($mock) {
            $mock->shouldReceive('process')
                ->once()
                ->andReturn('success');
        });

        $response = $this->actingAs($customer, 'sanctum')->postJson("/api/booking/{$booking->id}/payment");

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Payment successfully',
            ]);

    }
}
