<style>
    body {
        background: #f0f4f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 960px;
        margin: 40px auto;
        background: #fff;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
        border-radius: 8px;
        padding: 30px;
    }
    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    nav.navbar {
        background: #34495e;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ecf0f1;
    }
    nav.navbar a {
        color: #ecf0f1;
        margin-left: 15px;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    nav.navbar a:hover {
        color: #1abc9c;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }
    thead {
        background: #1abc9c;
        color: white;
        font-weight: 600;
    }
    thead th {
        padding: 12px 15px;
        text-align: center;
    }
    tbody tr {
        border-bottom: 1px solid #ddd;
        transition: background 0.3s ease;
    }
    tbody tr:hover {
        background: #eaf7f6;
    }
    tbody td {
        padding: 12px 15px;
        text-align: center;
        color: #555;
    }
    .empty-row {
        text-align: center;
        padding: 20px;
        color: #999;
        font-style: italic;
    }
    .green-row {
    background-color: #d4edda; /* أخضر فاتح */
    color: #08f43f; /* نص أخضر غامق */
}

.red-row {
    background-color: #f8d7da; /* أحمر فاتح */
    color: #f30921; /* نص أحمر غامق */
}

.empty-row {
    text-align: center;
    font-style: italic;
    color: #888;
}


</style>

    <h2>  سجل الطلبات </h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>السائق</th>
                <th>المتجر</th>
                <th>الحالة</th>
                <th>المبلغ الكلي</th>
                <th>تاريخ الطلب</th>
                <th>اجراء</th>
            </tr>
        </thead>
        <tbody>



            @forelse($orders as $order)

            @php
            $rowClass = '';
            if ($order->status == 'completed') {
                $rowClass = 'green-row';
            } elseif ($order->status == 'cancelled') {
                $rowClass = 'red-row';
            }
               @endphp

            <tr class="{{ $rowClass }}">
                <td>{{ $order->id }}</td>
                <td>{{ $order->driver->user->name ?? 'غير محدد' }}</td>  <!-- اسم السائق -->
                <td>{{ $order->vendor->store_name ?? 'غير محدد' }}</td>  <!-- اسم المتجر -->
                <td>{{ $order->status }}




                </td>


                <td>{{ number_format($order->total_amount, 2) }} دينار</td>
                <td>{{ $order->created_at}}</td>
                <td>

                    <form method="POST" action="{{ route('driver.orders.updateStatus', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()">
                            @php
                                $statuses = ['assigned', 'pending', 'in_progress', 'completed', 'cancelled'];
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" @if($order->status === $status) selected @endif>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </form>


                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-row">لا توجد طلبات حالياً</td>
            </tr>

            @endforelse
        </tbody>
    </table>
</div>



  <tr>
                            <td>{{ $order->id }}</td>

