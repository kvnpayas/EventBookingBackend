<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
  public function index(Request $request)
  {
    $cacheKey = 'event_list_' . md5($request->fullUrl());

    return Cache::remember($cacheKey, 60, function () use ($request) {
      $filterSearch = $request->search;
      $filterLocation = $request->location;
      $filterDate = $request->date;

      $query = Event::with('tickets')
        ->filterByDate('date', $filterDate)
        ->searchByTitle($filterSearch);

      if ($filterLocation) {
        $query->where('location', $filterLocation);
      }

      return $query->paginate(10);
    });
    // $filterSearch = $request->search;
    // $filterLocation = $request->location;
    // $filterDate = $request->date;

    // $query = Event::with('tickets')
    //   ->filterByDate('date', $filterDate)
    //   ->searchByTitle($filterSearch);


    // if ($filterSearch) {
    //   $query->where('title', 'like', '%' . $filterSearch . '%');
    // }

    // if ($filterLocation) {
    //   $query->where('location', $filterLocation);
    // }

    // if ($filterDate) {
    //   $query->where('date', $filterDate);
    // }

    // return $query->paginate(10);
  }

  public function show($id)
  {
    $event = Event::with('tickets')->findOrFail($id);

    return response()->json($event);
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'title' => 'required|string',
      'description' => 'nullable|string',
      'date' => 'required|date',
      'location' => 'required|string'
    ]);

    $validatedData['created_by'] = $request->user()->id;

    $event = Event::create($validatedData);

    Cache::flush();

    return response()->json([
      'event' => $event,
      'message' => 'Event created successfully',
    ], 201);
  }

  public function update(Request $request, Event $event)
  {
    $validatedData = $request->validate([
      'title' => 'required|string',
      'description' => 'nullable|string',
      'date' => 'required|date',
      'location' => 'required|string'
    ]);

    $user = $request->user();

    if ($event->created_by != $user->id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $event->update($validatedData);

    Cache::flush();

    return response()->json([
      'event' => $event,
      'message' => 'Event updated successfully',
    ], 200);


  }

  public function destroy(Request $request, Event $event)
  {
    $user = $request->user();

    if ($event->created_by != $user->id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $event->delete();

    Cache::flush();

    return response()->json(['message' => 'Event deleted']);
  }

}
