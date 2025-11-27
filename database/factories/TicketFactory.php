<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'type' => fake()->randomElement(['VIP', 'Standard', 'Gold', 'Silver']),
      'price' => fake()->randomFloat(2, 100, 2000),
      'quantity' => fake()->numberBetween(10, 200),
      'event_id' => Event::factory(),
    ];
  }
}
