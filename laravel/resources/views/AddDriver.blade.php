<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>إضافة سائق جديد</title>
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
          text-align: right;
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
<h2 style="text-align: center; color:#4B0082;">قائمة السائقين</h2>
<br>
<table  style="text-align: center;"  class="table table-bordered">
    <thead>
        <tr style="background-color: #eee;">
            <th style="padding: 10px; border: 1px solid #ccc;">#</th>
            <th style="padding: 10px; border: 1px solid #ccc;">معرف السائق</th>
            <th style="padding: 10px; border: 1px solid #ccc;"> الموقع</th>
            <th style="padding: 10px; border: 1px solid #ccc;">حالة الطلب  </th>
            <th style="padding: 10px; border: 1px solid #ccc;">أجراء   </th>
        </tr>
    </thead>
    <tbody>
        @forelse($drivers as $driver)
            <tr>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $driver->id }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $driver->user_id}}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $driver->latitude }}, {{ $driver->longitude }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">
                      {{ $driver->status}}

                </td>
                <td style="padding: 10px; border: 1px solid #ccc;">


                    <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('drivers.destroy', $driver) }}" method="POST" style="display:inline-block">
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

<hr style="margin: 40px 0;">
<div class="form-box">
    <h2>إضافة سائق جديد</h2>

    <form  action="{{ route('drivers.store') }}" method="POST">
        @csrf

    <div  class="mb-3">
        <select name="user_id" required>
            <option value="">اختر سائقاً</option>
            @foreach ($Duser as $user)
                <option value="{{ $user->id }}"
                    {{ old('user_id', $driver->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} (ID: {{ $user->id }})
                </option>
            @endforeach  </div>
    <div class="mb-3">
        <label> خطوط الطول </label>
        <input type="number" step="0.0000001" name="latitude" placeholder="latitude" value="" required>
    </div>
    <div class="mb-3">
        <label> خطوط العرض </label>
        <input type="number" step="0.0000001" name="longitude" placeholder="longitude" value="" required>
    </div>
    <label>حالة السائق </label>
    <select name="status">
        <option value="available">متاح</option>
        <option value="busy" >مشغول</option>
        <option value="offline">مغلق</option>
    </select>
        <button type="submit">حفظ</button>
    </form>
</body>
</html>
