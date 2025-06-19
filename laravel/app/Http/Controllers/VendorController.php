<?php

namespace App\Http\Controllers;
use App\Models\Store;
use App\Models\User;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use App\Models\Modules\Driver\Models\Driver;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function create(Request $request)
{
    $requestId = $request->input('request_id');
    $storeRequest = null;
    $userId = null;

    if ($requestId) {
        // نحاول إيجاد الطلب في جدول store_requests
        $storeRequest = Store::find($requestId);

        // نحاول إيجاد المتجر المرتبط بهذا الطلب (إن وجد)
        $vendor = Vendors::where('store_request_id', $requestId)->first();

        // إذا وجدنا المتجر، نحصل على user_id منه
        if ($vendor) {
            $userId = $vendor->user_id;
        }
           // 🟢 هنا يتم تحديث الحالة إلى "completed" (أو أي قيمة ترغب بها)
           if ($storeRequest) {
            $storeRequest->status = 'completed'; // أو مثلاً: $storeRequest->is_completed = 1;
            $storeRequest->save();
        }
    }

    $vendors = Vendors::latest()->get();

    return view('Addnewvender', compact('vendors', 'storeRequest', 'userId'));


}

  public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'user_id' => 'required|integer',
            'location' => 'nullable|string',
            'is_approved' => 'boolean',
            'payment_method' => 'nullable|string',
        ]);

        Vendors::create($request->all());

        return redirect()->route('Addnewvender')->with('success', 'تم إضافة المتجر بنجاح.');
    }








}
