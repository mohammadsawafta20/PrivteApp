<?php

namespace App\Http\Controllers;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\Modules\Driver\Models\Driver; // تأكد من استيراد Driver فقط

class AdminController extends Controller
{



public function indexuserpage(Request $request){

    $user_id = session('user_id');

    $vendor = Vendors::where('user_id', $user_id)->first();

    // البيانات الافتراضية لو لم يوجد متجر (اختياري)
    $storeName = $vendor->store_name ?? '';
    $latitude = $vendor->latitude ?? '';
    $longitude = $vendor->longitude ?? '';

    return view('UserPage', compact('storeName', 'latitude', 'longitude'));

    }


    public function Viewmap(){


        return view('Viewmap');

        }
        public function contacterror(){


            return view('contacterror');

            }
public function contact(){


    return view('contact');

    }
public function development(){


    return view('development');

    }

    // معالجة تحديث البيانات الشخصية من النموذج
    public function updateProfile (Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('يرجى تسجيل الدخول أولاً.');
        }

        // تحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
           'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',

        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        // تحديث بيانات المستخدم
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];

        // تحديث كلمة المرور إذا تم إدخالها
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

   // معالجة الصورة الجديدة
   
     if ($request->hasFile('profile_image')) {
    // حذف القديمة إن وُجدت
    if ($user->profile_image_path) {
        Storage::delete('public/uploads/' . $user->profile_image_path);
    }

        // رفع الصورة الجديدة
        $file = $request->file('profile_image');
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/uploads', $fileName);
        $user->profile_image_path = $fileName;
    }
        $user->save();
// تحديث بيانات الجلسة بعد تعديل صورة المستخدم
session([
    'user_name' => $user->name,
    'phone' => $user->phone,
    'images' => $user->profile_image_path, // تحديث الصورة
]);

        return redirect()->route('Profile.show')->with('success', 'تم تحديث البيانات بنجاح.');
    }



public function ProfilePageshow(){

    $user = Auth::user(); // استرجاع المستخدم الحالي

    if (!$user) {
        return redirect()->route('login')->withErrors(['يرجى تسجيل الدخول أولاً.']);
    }

    return view('ProfilePage', ['user' => $user]);
    }
    public function indexpage(Request $request)
{


    $user = Auth::user();
    $userId = session('user_id');
    $userRole = session('role');
    $userPhone = session('phone');
    $userName = session('user_name');

    $user_id = session('user_id');

    $vendor = Driver::where('user_id', $user_id)->first();

    // إذا لم يجد متجر، ابعث بيانات افتراضية (موقع عمان)
    $lat = $vendor->latitude ?? 31.9454;
    $lng = $vendor->longitude ?? 35.9284;
    $name = $name='my location';


    // جلب الطلبات الخاصة بالمستخدم المسجل فقط
    $orders = Order::where('vendor_id', $user->id)->latest()->get();
    return view('VendorPage', compact('userId', 'userRole','orders','userPhone', 'userName','lat', 'lng', 'name'));



}


    public function storerequest(Request $request){

 // تحقق من صحة البيانات المرسلة
 $validated = $request->validate([
    'store_name' => 'required|string|max:255',
    'latitude' => 'required|numeric',
    'longitude' => 'required|numeric',
    'details' => 'nullable|string',
    'status' => 'required|string|in:pending,approved,rejected',

]);

// إذا كان المستخدم مسجلاً، احصل على معرفه
$userId = auth()->check() ? auth()->id() : null;

// إنشاء الطلب
Store::create([
    'store_name' => $validated['store_name'],
    'latitude' => $validated['latitude'],
    'longitude' => $validated['longitude'],
    'details' => $validated['details'] ?? null,
    'status' => $validated['status'], // حالة افتراضية مثلاً
]);

session()->put('newRequest', true);

return redirect()->back()->with('success', 'تم إرسال الطلب بنجاح!');


    }


    // عرض صفحة الطلبات
    public function index()
    {
        // الطلبات غير المعتمدة
       // $requests = Store::all();
 // جلب الطلبات غير المكتملة فقط
 $requests = Store::where('status', '!=', 'completed')->get();
        // عدد الطلبات
        $ordersCount = Order::count();

        // عدد السائقين المتاحين (مثلاً الحالة = available)
        $availableDriversCount = Driver::where('status', 'available')->count();

        // جلب السائقين للنافذة المنبثقة
        $drivers = Driver::with('user')->get(); // يفترض أن علاقة user موجودة
   // استرجاع البيانات من الجلسة
    $userId = session('user_id');
    $userRole = session('role');
    $userPhone = session('phone');
    $userName = session('user_name');
    // تمرير البيانات إلى العرض
        return view('dashbord.Adminpage', compact('requests', 'ordersCount', 'availableDriversCount', 'drivers','userId', 'userRole', 'userPhone', 'userName'));
    }

    // الموافقة على الطلب وإضافته إلى جدول vendors
    public function approveRequest(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'store_request_id' => 'nullable|exists:store_requests,id',
            'payment_method' => 'nullable|string|max:255',
        ]);

        $vendor = Vendors::create([
            'store_name'     => $validated['store_name'],
            'latitude'       => $validated['latitude'],
            'longitude'      => $validated['longitude'],
            'location'       => $validated['location'],
            'user_id'        => $validated['user_id'],
            'store_request_id' => $validated ['store_request_id'],
            'payment_method' => $validated['payment_method'],
            'is_approved'    => true,
        ]);

        return redirect()->back()->with('success', 'تمت الموافقة على الطلب وإضافته للخريطة.');
    }

    // ربط السائق بالمتجر (vendor)
    public function assignDriver(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        // أنشئ الطلب الجديد
        Order::create([
            'vendor_id' => $validated['vendor_id'],
            'driver_id' => $validated['driver_id'],
            'total_amount'=>20,
            'status' => 'assigned', // حسب ما تحتاج
            'discount_percentage' => 0, // أو حسب المطلوب
        ]);

        return redirect()->back()->with('success', 'تم تعيين السائق بنجاح.');

    }
}

