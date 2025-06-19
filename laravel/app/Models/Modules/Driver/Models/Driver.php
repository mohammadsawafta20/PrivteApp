<?php

namespace App\Models\Modules\Driver\Models;
use App\Models\User;
use App\Models\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'latitude', 'longitude', 'status'];


public function activeOrder()
{
    return $this->hasOne(Order::class)->whereIn('status', ['assigned', 'in_progress'])->latestOfMany();
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsBusyAttribute()
    {
        // إن كان عنده طلب جاري مثلاً
        return $this->status == 'busy';
    }
    protected $guarded = [];

}
