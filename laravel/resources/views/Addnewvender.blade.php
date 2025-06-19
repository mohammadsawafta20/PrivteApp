<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>إضافة متجر جديد</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            padding: 30px;
        }

        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #4B0082;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4B0082;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .alert {
            background-color: #4BB543;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<h2 style="text-align: center; color:#4B0082;">قائمة المتاجر</h2>
<br>
<table  style="text-align: center;"  class="table table-bordered">
    <thead>
        <tr style="background-color: #eee;">
            <th style="padding: 10px; border: 1px solid #ccc;">#</th>
            <th style="padding: 10px; border: 1px solid #ccc;">اسم المتجر</th>
            <th style="padding: 10px; border: 1px solid #ccc;">معرف المتجر</th>
            <th style="padding: 10px; border: 1px solid #ccc;">الموقع</th>
            <th style="padding: 10px; border: 1px solid #ccc;">طريقة الدفع</th>
            <th style="padding: 10px; border: 1px solid #ccc;">حالة المتجر  </th>
            <th style="padding: 10px; border: 1px solid #ccc;">أجراء   </th>
        </tr>
    </thead>
    <tbody>
        @forelse($vendors as $vendor)
            <tr>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $vendor->id }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $vendor->store_name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $vendor->store_request_id }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $vendor->latitude }}, {{ $vendor->longitude }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">
                    {{ $vendor->payment_method === 'cash' ? '💵 كاش' : ($vendor->payment_method === 'credit' ? '💳 بطاقة' : '❓ غير معروف') }}


                </td>
                <td style="padding: 10px; border: 1px solid #ccc;">
                    {{ $vendor->is_approved ? '✅' : '❌' }}

                </td>
                <td style="padding: 10px; border: 1px solid #ccc;">


                    <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                    </form>


                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding: 10px; border: 1px solid #ccc; text-align:center;">لا توجد متاجر حالياً.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<hr>
<div class="form-box">
    <h2>إضافة متجر جديد</h2>

    @if($userId)
    <p>معرف المستخدم المرتبط: {{ $userId }}</p>
@endif
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif


    <form action="{{ route('vendors.store') }}" method="POST">
        @csrf
        <label>اسم المتجر:</label>
        <input type="text" name="store_name"  value="{{ $storeRequest->store_name ?? '' }}" required>

        <label>خط العرض:</label>
        <input type="number" step="any" name="latitude" value="{{ $storeRequest->longitude ?? '' }}" required>

        <label>خط الطول:</label>
        <input type="number" step="any" name="longitude"  value="{{ $storeRequest->latitude?? '' }}" required>

        <label>معرف المستخدم (user_id):</label>

        <input type="number" name="user_id"  value="{{ $userId ?? '' }}"          required>
        <label> معرف الطلبات (store_request_id):</label>
        <input type="number" name="store_request_id"  value="{{ $storeRequest->id ?? '' }}" required>

        <label>الموقع (نص اختياري):</label>
        <input type="text" name="location">

        <label>طريقة الدفع</label>
        <select name="payment_method">
            <option value="cash" {{ ($storeRequest->payment_method ?? '') == 'cash' ? 'selected' : '' }}>نقداً</option>
            <option value="credit" {{ ($storeRequest->payment_method ?? '') == 'credit' ? 'selected' : '' }}>بطاقة</option>
        </select>
        <label>موافقة:</label>
        <select name="is_approved">
            <option value="1">نعم</option>
            <option value="0">لا</option>
        </select>

        <button type="submit">حفظ</button>
    </form>
</div>
<hr style="margin: 40px 0;">


</body>
</html>
