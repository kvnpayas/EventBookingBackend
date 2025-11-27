<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;


trait CommonQueryScopes
{
  // Filter by Date
  public function scopeFilterByDate(Builder $query, $dateField, $value)
  {
    if ($value) {
      return $query->whereDate($dateField, $value);
    }

    return $query;
  }

  // FilterBy Search
  public function scopeSearchByTitle(Builder $query, $value)
  {
    if ($value) {
      return $query->where('title', 'like', "%$value%");
    }

    return $query;
  }
}
