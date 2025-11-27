<?php

namespace App\Models;

use App\Traits\CommonQueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
  use CommonQueryScopes, HasFactory;
  protected $fillable = [
    'created_by',
    'title',
    'description',
    'date',
    'location',
  ];

  public function organizer()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
