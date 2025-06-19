@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<h2 class="mb-4">إدارة المستخدمين</h2>
<a href="{{ route('users.search') }}" class="btn btn-info mb-3">🔍 بحث متقدم</a>

<form method="GET" action="#" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="phone" placeholder="رقم الجوال" value="{{ request('phone') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <select name="role" class="form-control">
            <option value="">كل الأدوار</option>
            <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>تاجر</option>
            <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>سائق</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدير</option>
        </select>
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">بحث</button>
        <a href="{{ route('users.create') }}" class="btn btn-success">إضافة مستخدم</a>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>البريد</th>
            <th>الجوال</th>
            <th>الدور</th>
            <th>نسبه الخصم</th>

            <th>الرصيد</th>
            <th>موافقة</th>
            <th>آخر دخول</th>
          <th>التقييم</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>


        @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->role }}</td>
<td>{{ $user->discount }}</td>
            <td>{{ $user->wallet_balance }}</td>
            <td>{{ $user->is_approved ? '✅' : '❌' }}</td>
            <td>{{ $user->last_login_at }}</td>
             <td>
                 @php
    $rating = $user->rating ?? 0;  // قيمة التقييم من 0 إلى 5
@endphp

<span style="color: gold; font-size: 1.5rem;">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rating)
            &#9733; {{-- نجمة مملوءة --}}
        @else
            &#9734; {{-- نجمة فارغة --}}
        @endif
    @endfor
</span>

                 
                 
                 
                 
             </td>
            <td>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">تعديل</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

{{ $users->appends(request()->query())->links() }}

@endsection
