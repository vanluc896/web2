@extends('admin.layouts.app')

@section('content')
    <h3>Danh sách đơn hàng</h3>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Khách</th>
            <th>SĐT</th>
            <th>Tổng tiền</th>
            <th>Xem</th>
            <th>Trạng thái</th>
        </tr>

        @foreach($orders as $o)
            <tr>
                <td>{{ $o->id }}</td>
                <td>{{ $o->customer->fullname ?? '' }}</td>
                <td>{{ $o->customer->phone ?? '' }}</td>
                <td>{{ number_format($o->total_amount) }} đ</td>
                <td>
                    <a href="{{ route('ad.order.show', $o->id) }}" class="btn btn-sm btn-primary">
                        Xem
                    </a>
                </td>
                <td>
                    @if($o->status == 'pending')
                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                    @else
                        <span class="badge bg-success">Đã xử lý</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    {{ $orders->links() }}
@endsection
