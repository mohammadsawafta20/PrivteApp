
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ تعديل الفرع: {{ $subarea->name }}</h2>

    <form method="POST" action="{{ route('subareas.update', $subarea->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">اسم الفرع:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $subarea->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="area_id" class="form-label">المنطقة الرئيسية:</label>
            <select name="area_id" id="area_id" class="form-control" required>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ $area->id == $subarea->area_id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="delivery_price" class="form-label">سعر التوصيل:</label>
            <input type="number" name="delivery_price" id="delivery_price" value="{{ old('delivery_price', $subarea->delivery_price) }}" class="form-control" step="0.01" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ التعديلات</button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>
@endsection

