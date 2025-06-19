<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Modules\Driver\Models\Driver; // تأكد من استيراد Driver فقط
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    

     use ApiResponseTrait;
     
 public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('phone', 'password'))) {
            return $this->errorResponse('بيانات الدخول غير صحيحة', [], 401);
        }

        $user = Auth::user();

        // تحديث حالة المستخدم
        $user->is_online = true;
        $user->last_login_at = now();
        $user->save();

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $user,
        ], 'تم تسجيل الدخول بنجاح');
    }
    //تسجيل مستخدم جديد 
    public function register(Request $request)
    {
        // تحقق من وجود رقم الهاتف مسبقاً
        $existingUser = User::where('phone', $request->phone)->first();
        if ($existingUser) {
            return $this->errorResponse('رقم الهاتف مستخدم بالفعل', [], 409);
        }

        // تحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|in:admin,vendor,driver',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'location_url' => 'nullable|url',
        ]);

        // رفع الصورة
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $fileName = Str::random(20) . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $storagePath = 'public/uploads/' . $fileName;

            if (!Storage::exists($storagePath)) {
                $request->file('profile_image')->storeAs('public/uploads', $fileName);
            }

            $profileImagePath = 'storage/uploads/' . $fileName;
        }

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'profile_image_path' => $profileImagePath,
            'location_url' => $request->location_url,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'تم تسجيل المستخدم بنجاح ويحتاج الحساب الى تفعيل من الأدارة');
    }
    
    
    //عرض  طلبات السائفين الجديده
    public function getAssignedOrdersForDriver()
    {
        // استرجاع المستخدم الحالي
        $user = auth()->user();
    
        // جلب بيانات السائق المرتبط بالمستخدم الحالي
        $driver = $user->driver; // تأكد أن العلاقة موجودة: User hasOne Driver
    
       if (!$driver) {
    return $this->errorResponse('لم يتم العثور على بيانات السائق', [], 404);
}

    
        // جلب الطلبات المسندة للسائق
        $assignedOrders = Order::where('driver_id', $driver->id)
                                ->where('status', 'assigned')
                                ->get();
    
        return response()->json([
            'driver' => $driver,
            'assigned_orders_count' => $assignedOrders->count(),
            'assigned_orders' => $assignedOrders
        ]);
    }
        //عرض  طلبات السائفين الجديده
    public function getAssignedOrdersForDrivercom()
    {
        // استرجاع المستخدم الحالي
        $user = auth()->user();
    
        // جلب بيانات السائق المرتبط بالمستخدم الحالي
        $driver = $user->driver; // تأكد أن العلاقة موجودة: User hasOne Driver
    
       if (!$driver) {
    return $this->errorResponse('لم يتم العثور على بيانات السائق', [], 404);
}

    
        // جلب الطلبات المسندة للسائق
        $assignedOrders = Order::where('driver_id', $driver->id)
                                ->where('status', 'completed')
                                ->get();
    
        return response()->json([
            'driver' => $driver,
            'assigned_orders_count' => $assignedOrders->count(),
            'assigned_orders' => $assignedOrders
        ]);
    }
    

    // 1. إرسال OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone'
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_otps')->insert([
            'phone' => $request->phone,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // فقط للتجربة، عرض الـ OTP في اللوق
        \Log::info("OTP for {$request->phone}: $otp");

        return response()->json(['message' => 'تم إرسال رمز التحقق']);
    }

    // 2. التحقق من OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $record = DB::table('password_otps')
            ->where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json(['message' => 'OTP غير صحيح أو منتهي'], 422);
        }

        return response()->json(['message' => 'OTP صحيح']);
    }

    // 3. إعادة تعيين كلمة المرور
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_otps')
            ->where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json(['message' => 'OTP غير صحيح أو منتهي'], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // حذف السجل بعد الاستخدام
        DB::table('password_otps')->where('phone', $request->phone)->delete();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح']);
    }

    
    //////////////////////////////////////////////////////////////

 public function completeOrder(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'الطلب غير موجود'], 404);
        }

        // تحقق أن السائق هو من يستكمل الطلب
        if ($order->driver_id !== auth()->id()) {
            return response()->json(['message' => 'غير مصرح لك بإكمال هذا الطلب'], 403);
        }

        // تحديث الحالة
        $order->status = 'completed';
        $order->save();
// تحديث حالة الطلب في جدول store_requests (إذا موجود)
    $storeRequest = Store::where('vendor_id', $order->vendor_id)
                                ->where('status', 'pending') // فقط الطلبات المعلقة
                                ->first();

    if ($storeRequest) {
        $storeRequest->status = 'completed';
        $storeRequest->save();
    }
    
        // تنفيذ عملية الخصم فقط من محفظة السائق
    $driverUser = $order->driver->user;
    $commission = $order->commission_rate ?? 0;

    // تحقق إن الرصيد كافٍ للخصم
    if ($driverUser->wallet_balance < $commission) {
        return response()->json(['message' => 'لا يوجد رصيد كافٍ في المحفظة لخصم العمولة'], 422);
    }

    $driverUser->wallet_balance -= $commission;
    $driverUser->save();
        return response()->json(['message' => 'تم إكمال الطلب بنجاح']);
    }


    public function assign(Request $request)
    {
        // ✅ التحقق من البيانات
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'البيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ التحقق إن كان هناك طلب مسبق لنفس المتجر لم يُكتمل
        $existingOrder = Order::where('vendor_id', $request->vendor_id)
                              ->whereIn('status', ['pending', 'assigned', 'in_progress'])
                              ->first();

        if ($existingOrder) {
            return response()->json([
                'message' => 'يوجد طلب جاري بالفعل لهذا المتجر'
            ], 400);
        }
    // جلب بيانات الطلب من store_requests
    $storeRequest = Store::where('vendor_id', $request->vendor_id)->latest()->first();

    if (!$storeRequest) {
        return response()->json(['message' => '❌ لا يوجد طلب مخزن لهذا المتجر في store_requests'], 404);
    }


    // جلب نسبة العمولة من حساب السائق (جدول users المرتبط بالسائق)
    $driver = Driver::with('user')->findOrFail($request->driver_id);
    $commissionRate = $driver->user->discount ?? 0;

    // إنشاء الطلب
    $order = Order::create([
        'driver_id' => $request->driver_id,
        'vendor_id' => $request->vendor_id,
        'status' => 'assigned',
        'total_amount' =>$storeRequest->total_amount, // يُمكن تحديثه لاحقًا
        'commission_rate' => $commissionRate, // يتم إضافته هنا
    ]);
        return response()->json([
            'message' => '✅ تم إسناد الطلب بنجاح',
            'order' => $order
        ]);
    }
//

public function online()
{
    $onlineAdmins = user::where('is_online', true)
        ->where('role', 'admin')
        ->get()
        ->map(function ($staff) {
            // تجهيز رقم الواتساب
            $localNumber = ltrim($staff->phone, '0'); // إزالة الصفر الأول
            $fullWhatsapp = '+972' . $localNumber;     // إضافة المقدمة الدولية

            // روابط التواصل
            $staff->call_link = 'tel:' . $staff->phone;
            $staff->whatsapp_link = 'https://wa.me/' . $fullWhatsapp;

            return $staff;
        });

    return response()->json([
        'status' => true,
        'message' => 'Online support admins only',
        'data' => $onlineAdmins
    ]);
}

}
