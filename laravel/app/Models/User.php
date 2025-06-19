<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Modules\Driver\Models\Driver; // استدعاء موديل السائق

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

        use HasApiTokens, Notifiable;


public function driver()
{
    return $this->hasOne(Driver::class);
}



    public function orders()
{
    // إذا عمود المفتاح الأجنبي في جدول الطلبات هو driver_id:
    return $this->hasMany(Order::class, 'driver_id');
}
    protected $fillable = [
        'name', 'phone', 'password', 'role', 'is_approved','email',
        'last_login_at','discount', 'wallet_balance', 'profile_image_path', 'location_url','rating','remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'is_approved' => 'boolean',
    ];
}
