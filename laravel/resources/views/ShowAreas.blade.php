@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📍 قائمة المناطق الرئيسية</h2>
    <a href="{{ route('areas.create') }}" class="btn btn-success mb-3">➕ إضافة منطقة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>اسم المنطقة</th>
                <th>الافرع</th>
                <th>تحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($area as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>
                        <ul>
                       @foreach($area->subareas as $sub)
    <li>
        🏷️ {{ $sub->name }}
        @if($sub->delivery_price)
            - 💰 {{ number_format($sub->delivery_price, 2) }} د.أ
        @endif

        <a href="{{ route('subareas.edit', $sub->id) }}" class="text-primary ms-2">✏️</a>

        <form action="{{ route('subareas.destroy', $sub->id) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button onclick="return confirm('حذف الفرع؟')" class="btn btn-sm btn-link text-danger">🗑️</button>
        </form>
    </li>
@endforeach

                        </ul>
                        <a href="{{ route('subareas.create', ['area_id' => $area->id]) }}" class="btn btn-sm btn-outline-secondary">➕ فرع</a>
                    </td>
                    <td>
                        <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-sm btn-primary">✏️ تعديل</a>
                        <form action="{{ route('areas.destroy', $area->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-sm btn-danger">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
