@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('admin.layouts.app')

@section('content')
    <h3>Chi tiết đơn #{{ $order->id }}</h3>

    <p><b>Khách:</b> {{ $order->customer->fullname }}</p>
    <p><b>SĐT:</b> {{ $order->customer->phone }}</p>
    <p><b>Địa chỉ:</b> {{ $order->customer->address }}</p>
    <p>
        <b>Thanh toán:</b>
        @if ($order->payment_status == 'paid')
            <span class="badge bg-success">Đã thanh toán</span>
        @else
            <span class="badge bg-danger">Chưa thanh toán</span>
        @endif
    </p>
<div class="d-flex justify-content-between align-items-center mb-3">

    {{-- STATUS BUTTON (KHÔNG CLICK) --}}
    <div>
        @if($order->status == 'pending')
            <button class="btn btn-outline-warning btn-sm" style="background-color:orangered; color:white"disabled>
                Chờ xử lý
            </button>
        @else
            <button class="btn btn-outline-success btn-sm" style="background-color: green; color:white" disabled>
                 Đã xử lý
            </button>
        @endif
    </div>

    {{-- ACTION BUTTON --}}
    <form action="{{ route('ad.order.updateStatus', $order->id) }}" method="POST">
        @csrf

        @if($order->status == 'pending')
            <button name="status" value="done" class="btn btn-success btn-sm">
             Xử lý đơn
            </button>
        @else
            <button name="status" value="pending" class="btn btn-warning btn-sm">
                Hoàn tác
            </button>
        @endif

    </form>

</div>

    <table class="table table-bordered">
        <tr>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>SL</th>
            <th>Thành tiền</th>
        </tr>

        @foreach($order->items as $i)
            <tr>
                <td>{{ $i->product->proname ?? '' }}</td>
<td>
    <img src="{{ asset('storage/products/' . ($i->product->thumbnail ?? 'default.png')) }}"
         width="70"
         height="70"
         class="rounded border"
         style="object-fit:cover;">
</td>
                <td>{{ number_format($i->price) }} đ</td>
                <td>{{ $i->quantity }}</td>
                <td>{{ number_format($i->subtotal) }} đ</td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('ad.order.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
