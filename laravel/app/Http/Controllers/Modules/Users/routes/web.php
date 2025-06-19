<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Users\Controllers\AdminController;
use Modules\Users\Controllers\VendorController;
use Modules\Users\Controllers\DriverController;



Route::prefix('users')->group(function () {
    Route::get('/admins', [AdminController::class, 'index'])->name('users.admins.index');
    Route::get('/vendors', [VendorController::class, 'index'])->name('users.vendors.index');
    Route::get('/drivers', [DriverController::class, 'index'])->name('users.drivers.index');
});
