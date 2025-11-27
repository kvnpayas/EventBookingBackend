<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
  public function index(Request $request)
  {
    $user = $request->user();

    $bookings = Booking::where('user_id', $user->id)->paginate(10);

    return $bookings;

  }
  public function store(Request $request, Ticket $ticket)
  {
    $validatedData = $request->validate([
      'quantity' => 'required|integer|min:1'
    ]);

    if ($validatedData['quantity'] > $ticket->quantity) {
      return response()->json(['message' => 'Not enough tickets'], 400);
    }

    $booking = Booking::create([
      'user_id' => $request->user()->id,
      'ticket_id' => $ticket->id,
      'quantity' => $validatedData['quantity'],
      'status' => 'pending'
    ]);

    return response()->json([
      'booking' => $booking,
      'message' => 'Booking created successfully',
    ], 201);
  }

  public function cancel(Request $request, Booking $booking)
  {
    $user = $request->user();
    $cancelBooking = $booking->where('user_id', $user->id)->first();

    if (!$cancelBooking) {
      return response()->json(['message' => 'Invalid Booking'], 400);
    }


    if ($cancelBooking->status !== 'pending') {
      return response()->json(['message' => 'Cannot cancel'], 400);
    }

    $cancelBooking->update(['status' => 'cancelled']);

    return response()->json(['message' => 'Booking cancelled']);
  }
}
