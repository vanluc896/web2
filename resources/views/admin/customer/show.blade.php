@extends('admin.layouts.app')

@section('title', 'Chi tiết khách hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Chi tiết khách hàng</h3>
        <a href="{{ route('ad.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div><span class="fw-semibold">Họ tên:</span> {{ $customer->fullname }}</div>
                </div>
                <div class="col-md-6">
                    <div><span class="fw-semibold">Email:</span> {{ $customer->email ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <div><span class="fw-semibold">Số điện thoại:</span> {{ $customer->phone }}</div>
                </div>
                <div class="col-md-6">
                    <div><span class="fw-semibold">Địa chỉ:</span> {{ $customer->address }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0">Đơn hàng của khách</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th width="120">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customer->orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ number_format($order->total_amount) }} đ</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('ad.order.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Khách hàng này chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
