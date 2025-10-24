<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFaq extends Model
{
    protected $table = 'support_faqs';
    protected $fillable = ['question','answer','is_active','order'];
    protected $casts = ['is_active'=>'boolean','order'=>'integer'];
}
