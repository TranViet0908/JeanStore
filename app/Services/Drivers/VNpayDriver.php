<?php

namespace App\Services\Drivers;

use App\Models\Payment;
use App\Services\ProviderDriver;
use Illuminate\Http\Request;

class VnpayDriver implements ProviderDriver
{
    public function createCheckout(\App\Models\Payment $p): string
    {
        $vpcUrl     = config('services.vnpay.vpc_url'); // đọc từ config/services.php
        $tmnCode    = trim(env('VNPAY_TMN_CODE'));
        $hashSecret = trim(env('VNPAY_HASH_SECRET'));

        $params = [
            'vnp_Version'    => '2.1.0',
            'vnp_Command'    => 'pay',
            'vnp_TmnCode'    => $tmnCode,
            'vnp_Amount'     => (int)$p->amount * 100,       // KHÔNG format, *100
            'vnp_CurrCode'   => 'VND',
            'vnp_TxnRef'     => 'PAY-' . $p->id,
            'vnp_OrderInfo'  => 'Thanh toan don #' . $p->order_id,
            'vnp_OrderType'  => 'other',
            'vnp_Locale'     => 'vn',
            'vnp_IpAddr'     => request()->ip(),
            'vnp_CreateDate' => now('Asia/Ho_Chi_Minh')->format('YmdHis'),
            'vnp_ReturnUrl'  => route('payments.vnpay.return', [
                'payment_id' => $p->id,
                'order_id'   => $p->order_id,
            ]),
            'vnp_SecureHashType' => 'HmacSHA512', // có trong query, KHÔNG đưa vào hashData
        ];

        // bỏ key rỗng/null
        $params = array_filter($params, fn($v) => $v !== null && $v !== '');

        ksort($params);

        // build hashData và query theo đúng guideline VNPAY (dùng urlencode)
        $hashData = '';
        $query    = '';
        foreach ($params as $key => $value) {
            if ($key === 'vnp_SecureHash' || $key === 'vnp_SecureHashType') {
                // loại trừ khi tạo hashData
                continue;
            }
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . '=' . urlencode((string)$value);
            $query    .= urlencode($key) . '=' . urlencode((string)$value) . '&';
        }

        $secureHash = hash_hmac('sha512', $hashData, $hashSecret);

        return $vpcUrl . '?' . $query . 'vnp_SecureHash=' . $secureHash;
    }

    public function verifyWebhook(Request $r): array
    {
        $input      = $r->all();
        $hashSecret = env('VNPAY_HASH_SECRET');
        $recvHash   = (string) ($input['vnp_SecureHash'] ?? '');

        // gom tham số vnp_* (trừ hash), sort, ký giống create
        $vnp = [];
        foreach ($input as $k => $v) {
            if (strpos($k, 'vnp_') === 0) $vnp[$k] = $v;
        }
        unset($vnp['vnp_SecureHash'], $vnp['vnp_SecureHashType']);

        ksort($vnp);
        $pieces = [];
        foreach ($vnp as $k => $v) {
            $pieces[] = urlencode($k) . '=' . urlencode((string) $v);
        }
        $hashData = implode('&', $pieces);
        $calc     = hash_hmac('sha512', $hashData, $hashSecret);

        $valid = hash_equals(strtoupper($recvHash), strtoupper($calc));
        $ok    = $valid && (($input['vnp_ResponseCode'] ?? '') === '00');

        $orderCode = (string) ($input['vnp_TxnRef'] ?? '');          // PAY-<payment_id>
        $txnId     = (string) ($input['vnp_TransactionNo'] ?? '');   // mã GD VNPAY

        return [$ok, $orderCode, $txnId, $input];
    }
}
