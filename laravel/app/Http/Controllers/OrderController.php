<?php

namespace App\Http\Controllers;
use App\Models\Modules\Order\Models\Order;
use App\Models\Modules\Driver\Models\Driver;
use App\Models\Modules\Vendors\Models\Vendors;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;






class OrderController extends Controller
{
    
    //المحفظه
     public function showInfo()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'driver') {
            abort(403, 'ليس لديك صلاحية ');
        }

        // البيانات التي نحتاجها
        $driverData = [
            'wallet_balance' => $user->wallet_balance,
            'rating'         => $user->rating,
            'discount'       => $user->discount,
        ];

        return view('cashdriver', compact('driverData'));
    }
    //المحغظه
    
    
    
    
    
    public function index()
    {
     //$orders = Order::all();
     $driver = Driver::find(1); // ID السائق الثابت مؤقتاً


     $orders = Order::with(['driver.user', 'Vendor'])->get();
        return view('Orderpage', compact('orders','driver'));

    }
public function updateStatus(Request $request, $orderId)
{
    $validStatuses = ['assigned', 'pending', 'in_progress', 'completed', 'cancelled'];

    $request->validate([
        'status' => 'required|in:' . implode(',', $validStatuses),
    ]);

    $order = Order::findOrFail($orderId);

    $order->status = $request->input('status');
    $order->save();

    return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح.');

}
}
