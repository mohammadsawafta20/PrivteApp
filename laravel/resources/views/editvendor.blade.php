@extends('layouts.app')

@section('title', 'تعديل بيانات المتجر')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        direction: rtl;
        background-color: #f9f9f9;
        padding: 40px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    form {
        direction: rtl;
        max-width: 600px;
        margin: 0 auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #444;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
        direction: rtl;
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
    }

    button {
        background-color: #3490dc;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2779bd;
    }

    .form-group {
        margin-bottom: 15px;
    }
</style>

@section('content')

<h2 dir="rtl" class="mb-4">تعديل المتجر</h2>

<form  dir="rtl"   action="{{ route('vendors.update', $vendor) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>معرف المتجر</label>
        <input type="number" name="store_request_id" placeholder="store_request_id" value="{{ old('store_request_id', $vendor->store_request_id ?? '') }}">
    </div>

    <div class="mb-3">
        <label>الاسم</label>
        <input type="text" name="store_name" placeholder="store_name" value="{{ old('store_name', $vendor->store_name ?? '') }}" required>
    </div>
    <div  class="mb-3">
        <label > معرف المستخدم </label>
        <input type="number" name="user_id" placeholder="user_id" value="{{ old('user_id', $vendor->user_id ?? '') }}" required>    </div>
    <div class="mb-3">
        <label> خطوط الطول </label>
        <input type="number" step="0.0000001" name="latitude" placeholder="latitude" value="{{ old('latitude', $vendor->latitude ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label> خطوط العرض </label>
        <input type="number" step="0.0000001" name="longitude" placeholder="longitude" value="{{ old('longitude', $vendor->longitude ?? '') }}" required>
    </div>
    <select name="is_approved" required>
        <option value="1" {{ old('is_approved', $vendor->is_approved ?? '') == 1 ? 'selected' : '' }}>نعم</option>
        <option value="0" {{ old('is_approved', $vendor->is_approved ?? '') == 0 ? 'selected' : '' }}>لا</option>
    </select>
    <label>طريقة الدفع</label>
        <select name="payment_method">
            <option value="cash" {{ ($vendor->payment_method ?? '') == 'cash' ? 'selected' : '' }}>نقداً</option>
            <option value="credit" {{ ($vendor->payment_method ?? '') == 'credit' ? 'selected' : '' }}>بطاقة</option>
        </select>
    <br>
    <button type="submit" id="submit-btn" class="btn btn-primary">حفظ</button>
</form>
@endsection
