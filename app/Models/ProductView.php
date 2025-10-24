<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $fillable = [
        'user_id','session_id','product_id','views_count','last_viewed_at'
    ];
    protected $casts = [
        'last_viewed_at' => 'datetime',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
