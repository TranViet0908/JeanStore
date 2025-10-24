<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        // nhớ tên bảng cart_items và khóa ngoại cart_id cho đúng migration của bạn
        return $this->hasMany(CartItem::class);
    }

    // Tổng tiền giỏ (nếu muốn dùng như $cart->subtotal)
    public function getSubtotalAttribute()
    {
        return $this->items->sum(fn ($i) => $i->price * $i->quantity);
    }
}
