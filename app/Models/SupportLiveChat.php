<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SupportLiveChat extends Model
{
    use HasFactory;

    protected $table = 'support_live_chats';

    protected $fillable = [
        'user_id','guest_token','guest_name','guest_email',
        'status','messages','started_at','ended_at','last_message_at',
    ];

    protected $casts = [
        'messages'        => 'array',
        'started_at'      => 'datetime',
        'ended_at'        => 'datetime',
        'last_message_at' => 'datetime',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_ENDED  = 'ended';

    protected static function booted(): void
    {
        static::creating(function (self $c) {
            // mặc định cho phiên guest
            if (empty($c->user_id) && empty($c->guest_token)) {
                $c->guest_token = 'guest_'.Str::lower(Str::random(6));
            }
            $c->status        = $c->status        ?: self::STATUS_ACTIVE;
            $c->started_at    = $c->started_at    ?: now();
            $c->messages      = $c->messages      ?: [];
            $c->last_message_at = $c->last_message_at ?: now();
        });
    }

    public function user() { return $this->belongsTo(User::class); }

    /** Thêm message vào mảng JSON và cập nhật mốc thời gian */
    public function pushMessage(string $body, ?string $by = null): void
    {
        $list = $this->messages ?? [];
        $list[] = [
            'at'   => now()->format('Y-m-d H:i:s'),
            'body' => $body,
            'by'   => $by, // 'user' | 'agent' | null
        ];
        $this->messages = $list;
        $this->last_message_at = now();
        $this->save();
    }
}
