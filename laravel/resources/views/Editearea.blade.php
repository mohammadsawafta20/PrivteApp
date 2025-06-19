@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ تعديل اسم المنطقة</h2>

    <form method="POST" action="{{ route('areas.update', $area->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">اسم المنطقة:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $area->name) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>
@endsection
