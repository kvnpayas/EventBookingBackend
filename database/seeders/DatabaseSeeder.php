<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 2 admins
        User::factory()->count(2)->create([
            'role' => 'admin'
        ]);

        // 3 organizers
        $organizers = User::factory()->count(3)->create([
            'role' => 'organizer'
        ]);

        // 10 customers
        $customers = User::factory()->count(10)->create([
            'role' => 'customer'
        ]);

        // 5 events (each owned by random organizer)
        $events = Event::factory()->count(5)->make()->each(function ($event) use ($organizers) {
            $event->created_by = $organizers->random()->id;
            $event->save();
        });

        // 15 tickets (random event)
        $tickets = Ticket::factory()->count(15)->make()->each(function ($ticket) use ($events) {
            $ticket->event_id = $events->random()->id;
            $ticket->save();
        });

        // 20 bookings (random users and tickets)
        Booking::factory()->count(20)->make()->each(function ($booking) use ($customers, $tickets) {
            $booking->user_id = $customers->random()->id;
            $booking->ticket_id = $tickets->random()->id;
            $booking->save();

        });

    }
}
