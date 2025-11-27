<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PaymentService;

class PaymentServiceTest extends TestCase
{
    public function test_payment_service_returns_valid_status()
    {
        $paymentService = new PaymentService();

        $result = $paymentService->process(500);

        $this->assertTrue(in_array($result, ['success', 'failed']));
    }
}
