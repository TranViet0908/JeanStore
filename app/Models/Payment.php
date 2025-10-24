<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    // dùng payment_date làm created_at, tắt updated_at
    public $timestamps = true;
    const CREATED_AT = 'payment_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'payment_date',
        'amount',
        'method',
        'status',
        'provider',
        'provider_txn_id',
        'provider_payload',
        'paid_at'
    ];

    protected $casts = [
        'payment_date'     => 'datetime',
        'paid_at'          => 'datetime',
        'provider_payload' => 'array',
        'amount'           => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
