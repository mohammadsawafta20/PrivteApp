@extends('layouts.app')

@section('title', 'إضافة مستخدم')

@section('content')
<h2  dir="rtl"  class="mb-4">إضافة مستخدم جديد</h2>

<form dir="rtl" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" >
    @csrf
    <input type="text" name="fake_user" style="display:none">

    <div class="mb-3">
        <label>الاسم</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3" dir="rtl">
        <label>البريد الإلكتروني</label>
        <input style="text-align: right;" type="email" name="email" class="form-control" autocomplete="off">
    </div>
    <div class="mb-3">
        <label>رقم الجوال</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label>كلمة المرور (اتركها فارغة إذا لا تريد التغيير)</label>
        <input type="password" name="password" class="form-control" id="password" autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="password_confirmation">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        <label id="password-error" style="color: red; display: none; margin-top: 5px;"></label>
    </div>

 <div class="mb-3">
        <label>صورة الملف الشخصي</label>
        <input type="file" name="profile_image" class="form-control">
    </div>
<label for="rating">التقييم:</label>
<select name="rating" id="rating">
    @for ($i = 0; $i <= 5; $i++)
        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
            {{ $i }} نجمة
        </option>
    @endfor
</select>

@error('rating')
    <div style="color: red;">{{ $message }}</div>
@enderror

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
            <option value="vendor">تاجر</option>
            <option value="driver">سائق</option>
            <option value="admin">مدير</option>
        </select>
    </div>
    <button type="submit" id="submit-btn" class="btn btn-primary">حفظ</button>
</form>
@endsection
