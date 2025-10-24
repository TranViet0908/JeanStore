<?php

namespace App\Services;

use App\Models\Payment;

interface ProviderDriver
{
    public function createCheckout(Payment $p): string;
}
