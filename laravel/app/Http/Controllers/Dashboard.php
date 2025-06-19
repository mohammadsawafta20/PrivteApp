<?php

namespace App\Http\Controllers;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use App\Models\User;
use App\Traits\ApiResponseTrait;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\Modules\Driver\Models\Driver; // تأكد من استيراد Driver فقط

class Dashboard extends Controller
{
        use ApiResponseTrait;

//استخراج بيانات السائق المحفظه ونسبه  الخصم والتقييم 
public function getDriverInfo()
{
    $user = auth()->user();

    if (!$user) {
        return $this->errorResponse('غير مصرح', [], 401);
    }

    // تحقق اختياري إذا كنت تريد فقط للسائقين
    if ($user->role !== 'driver') {
        return $this->errorResponse('هذا المستخدم ليس سائقاً', [], 403);
    }

    return $this->successResponse([
        'wallet_balance' => $user->wallet_balance,
        'rating'         => $user->rating,
        'discount'       => $user->discount,
    ], 'تم جلب بيانات السائق بنجاح');
}

public function toggleOnlineStatus(Request $request)
{
    $request->validate([
        'is_online' => 'required|in:1,0', // 1: online, 0: offline
    ]);

    $driver = Driver::where('user_id', auth()->id())->first();

    if (!$driver) {
        return $this->errorResponse('السائق غير موجود', [], 404);
    }

    $driver->is_online = $request->is_online;
    $driver->save();

    return $this->successResponse([
        'is_online' => (bool) $driver->is_online
    ], 'تم تحديث حالة الاتصال بنجاح');
}





    public function onlineDrivers()
    {
                $drivers = Driver::where('is_online', '1') // فقط السائقين المتصلين
        ->with(['user', 'activeOrder'])
        ->get();
    // تنسيق البيانات لإظهارها في JSON بشكل مرتب
    $data = $drivers->map(function ($driver) {
        return [
            'id' => $driver->id,
            'latitude' => $driver->latitude,
            'longitude' => $driver->longitude,
            'user' => [
                'name' => $driver->user->name ?? 'غير معروف',
                'phone' => $driver->user->phone ?? 'غير متوفر',
            ],
            'order' => $driver->activeOrder ? [
                'id' => $driver->activeOrder->id,
                'status' => $driver->activeOrder->status
            ] : null
        ];
    });

    return response()->json($data);
    }



public function withStatus()
{
 
 $vendors = Vendors::withCount([
        'storeRequests as pending_orders_count' => function ($query) {
            $query->where('status', 'pending');
        },
    ])
->with('user:id,name,phone')
->get();

$vendors = $vendors->map(function ($vendor) {
    return [
        'id' => $vendor->id,
        'name' => $vendor->user->name ?? 'غير معروف',
        'phone' => $vendor->user->phone ?? 'غير موجود',
        'latitude' => $vendor->latitude,
        'longitude' => $vendor->longitude,
        'has_pending_orders' => $vendor->pending_orders_count > 0, // true إذا فيه طلب معلق
        'pending_orders_count' => $vendor->pending_orders_count,
    ];
});

return response()->json([
    'status' => true,
    'vendors' => $vendors,
]);

    
}

    public function insertrequest(Request $request)
    {

            $request->validate([
                'store_name' => 'required|string|max:255',
                'details' => 'nullable|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
               'vendor_id' => 'required|exists:vendors,id'

            ]);

            $storeRequest = Store::create([
                'store_name' => $request->store_name,
                'details' => $request->details,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'pending',
                'vendor_id' => $request->vendor_id,
            ]);

            return response()->json([
                'message' => '✅ تم إرسال طلب  بنجاح  ',
                'data' => $storeRequest
            ], 201);

    }
// فحص  النتاحر اذا  هناك طلب جاري
public function assignDriver(Request $request)
{
    $request->validate([
        'driver_id' => 'required|exists:drivers,id',
        'vendor_id' => 'required|exists:vendors,id',
    ]);

    // تحقق من عدم وجود طلب جاري لنفس المتجر
    $existingOrder = Order::where('vendor_id', $request->vendor_id)
        ->where('status', '!=', 'completed')
        ->first();

    if ($existingOrder) {
        return $this->errorResponse('⚠️ هناك طلب جاري بالفعل لهذا المتجر', [], 400);
    }

    // جلب السائق مع بيانات المستخدم
    $driver = Driver::with('user')->findOrFail($request->driver_id);
    $commissionRate = $driver->user->discount ?? 0;

    // إنشاء الطلب
    $order = Order::create([
        'driver_id'       => $request->driver_id,
        'vendor_id'       => $request->vendor_id,
        'status'          => 'assigned',
        'commission_rate' => $commissionRate,
    ]);

    return $this->successResponse([
        'order' => $order,
    ], '✅ تم إنشاء الطلب وربط السائق بالمتجر');
}




    // دالة لعرض الصفحة
        public function dashboardView()
        {

    $vendors = Vendors::all();
    $drivers = Driver::where('status', 'available')->get();
    $stats = [
        'total_drivers' => Driver::where('status', 'available')->count(), // فقط المتاحين
        'total_vendors' => Vendors::count(),
        'total_orders' => Order::count(),
        'cancelled_orders' => Order::where('status', 'cancelled')->count(),
        'assigned_orders' => Order::where('status', 'assigned')->count(),
        'completed_orders' => Order::where('status', 'completed')->count(),
    ];

    return view('dashbord.dashbord', compact('vendors', 'drivers', 'stats'));
}


    public function mapData()
    {
        // جلب السائقين مع بيانات المستخدمين
        $drivers = Driver::with('user')->where('is_online', 'yes')->get();


        // جلب البائعين مع بيانات المستخدمين
        $vendors = Vendors::with('user')->where('is_online', 'yes')->get();


        // دمج البيانات وإرجاعها كـ JSON
        return response()->json([
            'drivers' => $drivers,
            'vendors' => $vendors,
        ]);

    }


}
