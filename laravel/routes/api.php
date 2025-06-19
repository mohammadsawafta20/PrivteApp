<?php
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Api\AuthController as SupportAuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use App\Models\Modules\Driver\Models\Driver;
use Illuminate\Support\Facades\Route;
use  app\Http\Controllers\Modules\Dashboard\Controllers\DashboardController;


Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});
//request all  data

//map
Route::get('/Drivers/online', [Dashboard::class, 'onlineDrivers']);
Route::get('/vendors/with-status', [Dashboard::class, 'withStatus']);
//endmap


//otps

Route::post('password/send-otp', [SupportAuthController::class, 'sendOtp']);
Route::post('password/verify-otp', [SupportAuthController::class, 'verifyOtp']);
Route::post('password/reset', [SupportAuthController::class, 'resetPassword']);

//otps
//pageadminonline
Route::get('/Support/online', [SupportAuthController::class, 'online']);
//insertdata in order table  ,driver , vendor
Route::post('/orders/assign', [SupportAuthController::class, 'assign']);
//اكتمال الطلب عن طريق زر 
Route::middleware('auth:sanctum')->post('/orders/{orderId}/complete', [SupportAuthController::class, 'completeOrder']);
Route::middleware('auth:sanctum')->post('/driver/toggle-online-status', [Dashboard::class, 'toggleOnlineStatus']);
//استعراض  المحفظه  ونسة الخصم
Route::middleware('auth:sanctum')->get('/driver/info', [Dashboard::class, 'getDriverInfo']);

//طلبات السائقين 
Route::middleware('auth:sanctum')->get('/driver/assigned-orders', [SupportAuthController::class, 'getAssignedOrdersForDriver']);
Route::middleware('auth:sanctum')->get('/driver/assigned-orderscom', [SupportAuthController::class, 'getAssignedOrdersForDrivercom']);

//طلبات السائقين


//regester user
Route::post('/register', [SupportAuthController::class, 'register']);
//login user
Route::post('/login', [SupportAuthController::class, 'login']);

//عرض  بيانات اليوزر مع الصورة apis
Route::get('/user/{id}', function ($id) {
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'role' => $user->role,
        'profile_image_url' => $user->profile_image_path
            ? url($user->profile_image_path) // ⬅️ مسار URL جاهز للعرض في التطبيق أو المتصفح
            : null,
    ]);
});



//logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $user = $request->user();

    // تغيير حالة المستخدم إلى أوف لاين
    $user->is_online = false;
    $user->save();

    // حذف التوكن الحالي
    $user->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully']);
});

Route::post('/orders', [Dashboard::class, 'store']);

Route::post('/map/assign', [Dashboard::class, 'assignDriver']);
//insert request data
Route::post('/store-request', [Dashboard::class, 'insertrequest']);
//orders
Route::get('/orders', function () {
    $orders = Order::with(['driver', 'vendor'])->get();

    return response()->json($orders);
});


Route::middleware('auth:sanctum')->put('/orders/{id}/status', function (Request $request, $id) {
    $request->validate([
        'status' => 'required|string|in:pending,processing,completed,cancelled',
    ]);

    $user = auth()->user();
    // شرط: لازم يكون درايفر
    if ($user->role !== 'driver') {
        return response()->json(['message' => 'Only drivers can update order status.'], 403);
    }

    // البحث عن الطلب ويجب أن يكون مرتبط بنفس السائق
    $order = Order::where('id', $id)
                  ->where('driver_id', $user->id)
                  ->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found or access denied.'], 403);
    }

    $order->status = $request->status;
    $order->save();

    return response()->json([
        'message' => 'Order status updated successfully.',
        'order' => $order,
    ]);
});


Route::get('/map/data', [Dashboard::class, 'mapData']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/

