<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
  use HasFactory;
  protected $fillable = [
    'event_id',
    'type',
    'price',
    'quantity',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }

  public function bookings()
  {
    return $this->hasMany(Booking::class);
  }
}
