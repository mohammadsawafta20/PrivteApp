@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📋 قائمة الفروع</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('subareas.create') }}" class="btn btn-success mb-3">➕ إضافة فرع جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>اسم الفرع</th>
                <th>سعر التوصيل </th>
                <th>تحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subareas as $sub)
                <tr>
                    <td>{{ $sub->name }}</td>
                    <td>{{ $sub->delivery_price}}</td>
                    <td>
                        <a href="{{ route('subareas.edit', $sub->id) }}" class="btn btn-sm btn-primary">✏️ تعديل</a>

                        <form action="{{ route('subareas.destroy', $sub->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('هل تريد حذف هذا الفرع؟')">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
