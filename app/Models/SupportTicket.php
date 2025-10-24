<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets';

    protected $fillable = [
        'code','user_id','requester_email','requester_name','subject','content',
        'status','priority','assigned_to','conversation','order_id',
        'last_message_at','closed_at'
    ];

    protected $casts = [
        'conversation'    => 'array',
        'last_message_at' => 'datetime',
        'closed_at'       => 'datetime',
    ];

    // constants trạng thái và mức ưu tiên
    public const STATUS_OPEN    = 'open';
    public const STATUS_PENDING = 'pending';
    public const STATUS_CLOSED  = 'closed';

    public const PRIORITY_LOW    = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_HIGH   = 'high';

    protected static function booted(): void
    {
        static::creating(function (self $t) {
            if (empty($t->code)) {
                $t->code = self::genCode();
            }
            $t->status   = $t->status   ?: self::STATUS_OPEN;
            $t->priority = $t->priority ?: self::PRIORITY_NORMAL;

            if (!empty($t->content) && empty($t->last_message_at)) {
                $t->last_message_at = now();
            }
        });
    }

    public static function genCode(): string
    {
        return 'TKT' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
    }

    // Quan hệ
    public function user()     { return $this->belongsTo(User::class,  'user_id'); }
    public function assignee() { return $this->belongsTo(User::class,  'assigned_to'); }
    public function order()    { return $this->belongsTo(Order::class, 'order_id'); }
}
