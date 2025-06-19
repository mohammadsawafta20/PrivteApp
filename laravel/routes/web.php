<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\SubareaController;
use App\Http\Controllers\EditVendorController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


//المحفظه
Route::middleware(['auth'])->get('/driver/info', [OrderController::class, 'showInfo'])->name('driver.info');



//ملفات الصوت

Route::get('/audio/{filename}', function ($filename) {
    // تحقق من امتداد الملف المسموح به (صوت فقط)
    $allowedExtensions = ['mp3', 'wav', 'ogg', 'm4a', 'flac'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        abort(403, 'هذا الملف غير مسموح به.');
    }

    $path = storage_path('app/public/uploads/' . $filename);

    if (!File::exists($path)) {
        abort(404, 'الملف غير موجود.');
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
});


//  ملفات الصور 
Route::get('/image/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!File::exists($path)) {
        abort(404, 'File not found.');
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//login page

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


//end
//admin page


Route::post('/dashboard/approve-request', [Dashboard::class, 'approveRequest'])->name('dashbord.approve.request');

Route::resource('areas', AreaController::class)->names('areas');
Route::resource('subareas', SubareaController::class)->names('subareas');


//end
//user page

Route::get('/contacterror', [AdminController::class, 'contacterror'])->name('contacterror.users');
Route::get('/contact', [AdminController::class, 'contact'])->name('contact.users');
Route::get('/development', [AdminController::class, 'development']);
//users
// عرض قائمة المستخدمين مع البحث
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

// صفحة إنشاء مستخدم جديد
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// حفظ مستخدم جديد
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// صفحة تعديل مستخدم
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// تحديث بيانات المستخدم
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// حذف مستخدم
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

//Vendors
Route::get('/vendors/{vendor}/edit', [EditVendorController::class, 'edit'])->name('vendors.edit');
Route::put('/vendors/{vendor}', [EditVendorController::class, 'update'])->name('vendors.update');
Route::delete('/vendors/{vendor}', [EditVendorController::class, 'destroy'])->name('vendors.destroy');
Route::get('vendors/create', [VendorController::class, 'create'])->name('Addnewvender');
Route::post('vendors/store', [VendorController::class, 'store'])->name('vendors.store');
//Drivers
Route::get('/drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
Route::get('drivers/create', [DriverController::class, 'index'])->name('drivers.show');
Route::get('/DriverPage', [DriverController::class, 'showpage'])->name('drivers.showpage');

Route::post('drivers/store', [DriverController::class, 'store'])->name('drivers.store');



//users
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/Adminpage', [AdminController::class, 'index'])->name('admin.page');

    Route::get('/dashboard', [Dashboard::class, 'dashboardView']);
    Route::get('/VendorPage', [ AdminController::class, 'indexpage']);
    Route::get('/ProfilePage', [AdminController::class, 'ProfilePageshow'])->name('Profile.show');
Route::match(['post', 'put'], '/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

});


Route::get('/userpage', [AdminController::class, 'indexuserpage'])->name('userpage.index');
Route::get('/Viewmap', [AdminController::class, 'Viewmap'])->name('Viewmap.index');
Route::post('/insertrequest', [AdminController::class, 'storerequest'])->name('insertrequest.storerequest');
//end
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::post('/driver/status', [DriverController::class, 'updateStatusdriver'])->name('driver.status.update');
Route::patch('/driver/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('driver.orders.updateStatus');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/assign-driver', [AdminController::class, 'assignDriver'])->name('dashbord.assign.driver');
Route::post('/store/request', [AdminController::class, 'storeee'])->name('storeee.request');
