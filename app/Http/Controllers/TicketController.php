<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
  public function store(Request $request, Event $event)
  {
    $user = $request->user();

    if ($event->created_by != $user->id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'type' => 'required|string',
      'price' => 'nullable|numeric',
      'quantity' => 'required|integer',
    ]);

    $validatedData['event_id'] = $event->id;

    $ticket = Ticket::create($validatedData);

    return response()->json([
      'ticket' => $ticket,
      'message' => 'Ticket created successfully',
    ], 201);
  }

  public function update(Request $request, Ticket $ticket)
  {
    $event = $ticket->event;
    $user = $request->user();

    if ($event->created_by != $user->id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'type' => 'required|string',
      'price' => 'nullable|numeric',
      'quantity' => 'required|integer',
    ]);

    $ticket->update($validatedData);

    return response()->json([
      'ticket' => $ticket,
      'message' => 'Ticket updated successfully',
    ], 200);

  }

  public function destroy(Request $request, Ticket $ticket)
  {
    $event = $ticket->event;
    $user = $request->user();

    if ($event->created_by != $user->id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $ticket->delete();

    return response()->json(['message' => 'Ticket deleted']);
  }
}
