@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('subareas.store') }}">
    @csrf
    <label>الفرع:</label>
    <input type="text" name="name" class="form-control" required>

    <label>الموقع الرئيسي:</label>
    <select name="area_id" class="form-control" required>
        @foreach($areas as $area)
            <option value="{{ $area->id }}">{{ $area->name }}</option>
        @endforeach
    </select>

    <label>السعر:</label>
    <input type="number" name="delivery_price" class="form-control" step="0.01" min="0" placeholder="أدخل السعر" >

    <button type="submit" class="btn btn-success mt-2">حفظ</button>
</form>

@endsection


