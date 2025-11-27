<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/me', [AuthController::class, 'me']);
});


// EVENT
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store'])->middleware(['auth:sanctum', 'role:organizer']);
Route::put('/events/{event}', [EventController::class, 'update'])->middleware(['auth:sanctum', 'role:organizer']);
Route::delete('/events/{event}', [EventController::class, 'destroy'])->middleware(['auth:sanctum', 'role:organizer']);


// Ticket
Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->middleware(['auth:sanctum', 'role:organizer']);
Route::put('/ticket/{ticket}', [TicketController::class, 'update'])->middleware(['auth:sanctum', 'role:organizer']);
Route::delete('/ticket/{ticket}', [TicketController::class, 'destroy'])->middleware(['auth:sanctum', 'role:organizer']);

// Bookings
Route::post('/tickets/{ticket}/booking', [BookingController::class, 'store'])->middleware(['auth:sanctum', 'role:customer']);
Route::get('/bookings', [BookingController::class, 'index'])->middleware(['auth:sanctum', 'role:customer']);
Route::put('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->middleware(['auth:sanctum', 'role:customer']);

// Payment
Route::post('/booking/{bookingId}/payment', [PaymentController::class, 'store'])->middleware(['auth:sanctum', 'role:customer']);
Route::get('/payment/{payment}', [PaymentController::class, 'index'])->middleware(['auth:sanctum', 'role:customer']);