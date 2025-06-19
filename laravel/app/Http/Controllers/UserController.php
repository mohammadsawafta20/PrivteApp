<?php

namespace App\Http\Controllers;
use App\Models\Modules\Vendors\Models\Vendors;
use App\Models\Modules\Order\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Modules\Driver\Models\Driver;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $query = User::query();

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('users.admins.index', compact('users'));
    }

    public function create()
    {
        
        
        return view('users.admins.create');
    }
    public function search(Request $request)
    {
        $query = User::query();

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('users.admins.search', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|unique:users,phone',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,driver,vendor',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',

            

        ]);
        
        $profileImagePath = null;

if ($request->hasFile('profile_image')) {
    $file = $request->file('profile_image');

    // اسم عشوائي
    $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

    // رفع الصورة في storage/app/public/uploads
    $file->storeAs('public/uploads', $fileName);

    // حفظ المسار
    $profileImagePath =  $fileName;
}


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'profile_image_path' => $profileImagePath,
            'rating' => $request->rating,

        ]);

        return redirect()->route('users.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(User $user)
    {
        return view('users.admins.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $user->id,
            'role' => 'required|in:admin,driver,vendor',
            'password' => 'nullable|string|min:6', // حقل اختياري للتحديث
            'is_approved' => 'required|in:0,1', // تأكيد صحة القيمة
            'wallet_balance' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
          'rating' => 'nullable|integer|min:0|max:5',


        ]);

        $data = $request->only('name', 'email', 'phone', 'role','is_approved','wallet_balance','discount','rating');

          // ✅ هنا نحدث قيمة is_approved سواء كانت 0 أو 1
          $data['is_approved'] = $request->input('is_approved', 0); // القيمة الافتراضية 0

           // إذا تم إدخال كلمة مرور، نضيفها مشفرة
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم الحذف بنجاح');
    }

    }

