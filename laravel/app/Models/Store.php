<?php

namespace App\Models;
use App\Models\Modules\Driver\Models\Driver; // استدعاء موديل السائق
use App\Models\Modules\Vendors\Models\Vendors; // استدعاء موديل المتجر
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    use HasFactory;

    protected $table = 'store_requests';

    protected $fillable = [
        'store_name',
        'details',
        'latitude',
        'longitude',
        'vendor_id',
        'status',


    ];

    public function orders()
{
    // إذا عمود المفتاح الأجنبي في جدول الطلبات هو driver_id:
    return $this->hasMany(Order::class, 'driver_id');
}

   public function vendors()
    {
        // علاقة hasMany لأن المتجر لديه عدة vendors
        return $this->hasMany(Vendors::class, 'store_request_id');
    }
}
