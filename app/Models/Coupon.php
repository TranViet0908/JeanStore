<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code','type','value','max_uses','used','max_discount','min_order_total',
        'starts_at','ends_at','active'
    ];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'active'    => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')
            ->withPivot(['per_user_limit','redeemed'])
            ->withTimestamps();
    }

    public function isActiveNow(): bool
    {
        $now = now();
        if (!$this->active) return false;
        if ($this->starts_at && $now->lt($this->starts_at)) return false;
        if ($this->ends_at && $now->gt($this->ends_at)) return false;
        if ($this->max_uses && $this->used >= $this->max_uses) return false;
        return true;
    }

    public function computeDiscount(int $orderTotal): int
    {
        if ($orderTotal < (int)$this->min_order_total) return 0;
        $raw = $this->type === 'percent'
            ? intdiv($orderTotal * (int)$this->value, 100)
            : (int)$this->value;
        $cap = (int)$this->max_discount;
        return max(0, $cap > 0 ? min($raw, $cap) : $raw);
    }
}
