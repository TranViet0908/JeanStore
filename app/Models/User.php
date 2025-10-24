<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password_hash',
        'role',
        'phone',
        'address',
        'created_at',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Accessor for password attribute
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is regular user
    public function isUser()
    {
        return $this->role === 'user';
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(\App\Models\Coupon::class, 'user_coupons')
            ->withPivot(['per_user_limit','redeemed'])
            ->withTimestamps();
    }
}
