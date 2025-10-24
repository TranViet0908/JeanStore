<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Khai báo bảng (nếu trùng thì bỏ qua)
    protected $table = 'orders';

    // Cho phép fillable để mass assignment
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
    ];

    // Nếu cần cast dữ liệu cho đẹp
    protected $casts = [
        'total' => 'decimal:2',
    ];

    // Quan hệ: Một Order thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
