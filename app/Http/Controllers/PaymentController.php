<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Notifications\BookingConfirmedNotification;

class PaymentController extends Controller
{
  public function store(Request $request, $bookingId)
  {
    $user = $request->user();
    $booking = Booking::where('user_id', $user->id)->findOrFail($bookingId);
    $ticket = $booking->ticket;

    if ($booking->status == 'cancelled') {
      return response()->json(['message' => 'This booking is cancelled. Payment did not proceed.'], 400);
    }

    if ($booking->payment) {
      return response()->json(['message' => 'Booking already paid.'], 400);
    }

    $amount = $ticket->price * $booking->quantity;

    $status = app(PaymentService::class)->process($amount);


    $payment = Payment::create([
      'booking_id' => $booking->id,
      'amount' => $amount,
      'status' => $status
    ]);

    if ($status === 'success') {
      $updatedQuantity = (int) $ticket->quantity - (int) $booking->quantity;

      $ticket->update(['quantity' => $updatedQuantity]);
      $booking->update(['status' => 'confirmed']);

      $booking->user->notify(new BookingConfirmedNotification($booking));

      return response()->json([
        'payment' => $payment,
        'message' => 'Payment successfully',
      ], 201);
    } else {
      return response()->json([
        'payment' => $payment,
        'message' => 'Payment failed',
      ], 402);
    }




  }

  public function index(Payment $payment)
  {
    return response()->json($payment);
  }
}
