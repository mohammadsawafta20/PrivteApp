<?php

namespace App\Models\Modules\Order\Models;
use App\Models\Store;
use App\Models\Modules\Driver\Models\Driver; // استدعاء موديل السائق
use App\Models\Modules\Vendors\Models\Vendors; // استدعاء موديل المتجر

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'vendor_id',
        'status',
        'total_amount',
        'commission_rate'
    ];




    // علاقة الطلب بالسائق
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // علاقة الطلب بالمتجر
    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }



   



}
