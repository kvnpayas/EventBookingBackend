<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $ticket = $request->route('ticket');
    $user = $request->user();

    $exists = Booking::where('user_id', $user->id)
      ->where('ticket_id', $ticket->id)
      ->whereIn('status', ['pending', 'confirmed'])
      ->exists();

    if ($exists) {
      return response()->json([
        'message' => 'You already booked this ticket.'
      ], 400);
    }
    return $next($request);
  }
}
