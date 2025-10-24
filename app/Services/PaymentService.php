<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Payment;
// ===== ĐOẠN THÊM =====
use App\Services\Drivers\VnpayDriver;
// ===== HẾT ĐOẠN THÊM =====

interface ProviderDriver {
    public function createCheckout(Payment $p): string;
    /** @return array{0:bool,1:string,2:string,3:array} */
    public function verifyWebhook(Request $r): array;
}

class PaymentService
{
    public function using(string $provider): ProviderDriver
    {
        return match ($provider) {
            'vnpay' => app(VnpayDriver::class),
        };
    }

    public function detectProvider(Request $r): string
    {
        if ($r->has('vnp_SecureHash')) return 'vnpay';
        abort(400, 'unknown provider');
    }
}
