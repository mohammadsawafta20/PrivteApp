<?php

namespace App\Http\Controllers;
use App\Models\Modules\Order\Models\Order;
use App\Models\Modules\Driver\Models\Driver;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DriverController extends Controller
{


    public function index()
    {

        $Duser = User::where('role', 'driver')
                   ->where('is_approved', 0)
                   ->get();

        $drivers = Driver::all();
        return view('AddDriver', compact('drivers','Duser'));
    }
    public function showpage(Request $request)
    {


            $userId = session('user_id');
            $userRole = session('role');
            $userPhone = session('phone');
            $userName = session('user_name');

            $user_id = session('user_id');

    $drivers = Driver::where('user_id', $user_id)->first();

    // إذا لم يجد متجر، ابعث بيانات افتراضية (موقع عمان)
    $lat = $drivers->latitude ?? 31.9454;
    $lng = $drivers->longitude ?? 35.9284;
    $name = $drivers->store_name ?? 'موقع افتراضي';

    $user = Auth::user();

    // جلب الطلبات الخاصة بالمستخدم المسجل فقط
    $orders = Order::where('driver_id', $user->id)->latest()->get();

            return view('DriverPage', compact('userId', 'userRole', 'orders', 'userPhone', 'userName', 'lat', 'lng', 'name'));


    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|string',
        ]);

        Driver::create($request->all());
        User::where('id', $request->user_id)->update(['is_approved' => 1]);
        return redirect()->route('drivers.show')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(Driver $driver)
    {
        return view('EditDrivers', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $driver->update($request->all());
        return redirect()->route('drivers.show')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.show')->with('success', 'تم الحذف بنجاح');
    }
}
