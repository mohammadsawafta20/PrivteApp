<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login.login');

    }

    public function logout(Request $request)
{
    // مسح جميع بيانات الجلسة
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح');
}


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string|min:10',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,vendor,driver',
        ]);

        $user = User::where('phone', $credentials['phone'])
                    ->where('role', $credentials['role'])
                    ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect()->route('login')->with('error', 'بيانات الدخول غير صحيحة');
        }
        if (!$user->is_approved) {
            Auth::logout(); // تسجيل الخروج فورًا
            return redirect()->route('contacterror.users')->withErrors([
                'email' => 'الحساب غير مفعل من قبل الإدارة. الرجاء التواصل مع الدعم.'
            ]);
        }


        Auth::login($user);
        $request->session()->regenerate();
        session([
            'user_id' => $user->id,
            'role' => $user->role,
            'user_name' => $user->name,// إضافة معلومات إضافية إذا لزم الأمر
            'phone'=>$user->phone,
            'images'=>$user->profile_image_path,
        ]);

        return match ($user->role) {
            'admin' => redirect('/Adminpage'),
            'vendor' => redirect('/VendorPage'),
            'driver' => redirect('/DriverPage'),
        };
    }
}


