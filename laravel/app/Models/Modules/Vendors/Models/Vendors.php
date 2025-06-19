<?php

namespace App\Models\Modules\Vendors\Models;
use App\Models\User;
use App\Models\Store;
use App\Models\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

   // أسماء الأعمدة القابلة للتعبئة
   protected $fillable = [
    'store_name',
    'latitude',
    'longitude',
    'user_id',
    'location',
    'store_request_id',
    'is_approved',
    'payment_method',
];

// النوع التلقائي للتحويل
protected $casts = [
    'is_approved' => 'boolean',
    'latitude' => 'float',
    'longitude' => 'float',
];

// علاقة مع المستخدم (اختياري إذا أردت ربط المتجر بالمستخدم)
public function user()
{
    return $this->belongsTo(User::class, 'user_id');


}
public function orders()
{
    return $this->hasMany(Order::class, 'vendor_id');


}
public function storeRequests()
{
    return $this->hasMany(Store::class, 'vendor_id');



}


}


