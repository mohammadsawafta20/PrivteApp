@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('areas.store') }}">
    @csrf
    <label>اسم المنطقة:</label>
    <input type="text" name="name" class="form-control" required>
    <button type="submit" class="btn btn-success mt-2">حفظ</button>
</form>

@endsection
