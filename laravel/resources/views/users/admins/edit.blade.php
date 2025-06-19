@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('content')
<h2 dir="rtl" class="mb-4">تعديل المستخدم</h2>

<form  dir="rtl"   action="{{ route('users.update', $user) }}" method="POST"  autocomplete="off">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>الاسم</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
    </div>
    <div  class="mb-3">
        <label >البريد الإلكتروني</label>
        <input  style="text-align: right;" type="email" name="email" value="{{ $user->email }}"   autocomplete="email"  class="form-control">
    </div>
    <div class="mb-3">
        <label>رقم الجوال</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>كلمة المرور (اتركها فارغة إذا لا تريد التغيير)</label>
        <input type="password" name="password" class="form-control"   autocomplete="off"   id="password">
    </div>
    <div class="mb-3">
        <label for="password_confirmation">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        <label id="password-error" style="color: red; display: none; margin-top: 5px;"></label>
    </div>



    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const errorLabel = document.getElementById('password-error');
        const submitBtn = document.getElementById('submit-btn');

        function checkPasswords() {
            if (confirmPassword.value.length === 0 && password.value.length === 0) {
                errorLabel.style.display = 'none';
                submitBtn.disabled = false;
                return;
            }

            if (password.value === confirmPassword.value) {
                errorLabel.style.display = 'none';
                errorLabel.textContent = '';
                submitBtn.disabled = false;
            } else {
                errorLabel.style.display = 'block';
                errorLabel.textContent = 'كلمات المرور غير متطابقة';
                submitBtn.disabled = true;
            }
        }

        password.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);
    });
    </script>

    <div class="mb-3">
        <label>الدور</label>
        <select name="role" class="form-control">
            <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>تاجر</option>
            <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>سائق</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
        </select>
    </div>
    <div class="mb-3">
        <label>الرصيد</label>
        <input type="number" step="0.01" name="wallet_balance" value="{{ $user->wallet_balance }}" class="form-control">
    </div>
      <div class="mb-3">
        <label>نسبه  الخصم</label>
        <input type="number" step="0.01" name="discount" value="{{ $user->discount }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>موافقة</label>
        <select name="is_approved" class="form-control">
            <option value="0" {{ $user->is_approved == 0 ? 'selected' : '' }}>غير موافق</option>
            <option value="1" {{ $user->is_approved == 1 ? 'selected' : '' }}>موافق</option>
        </select>
    </div>
    
<label for="rating">التقييم:</label>
<select name="rating" id="rating">
    @for ($i = 0; $i <= 5; $i++)
        <option value="{{ $i }}" 
            {{ (old('rating') !== null ? old('rating') : $user->rating) == $i ? 'selected' : '' }}>
            {{ $i }} نجمة
        </option>
    @endfor
</select>

@error('rating')
    <div style="color: red;">{{ $message }}</div>
@enderror

 <br><br>
    <button type="submit" id="submit-btn" class="btn btn-primary">حفظ</button>

@endsection
