<?php

namespace App\Services;

class PaymentService
{
  // Simulate Payment method 80% success

  public function process($amount)
  {
    $random = rand(1, 100);

    if ($random <= 80) {
      return 'success';
    }

    return 'failed';
  }
}

