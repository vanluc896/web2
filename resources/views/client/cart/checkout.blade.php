@extends('client.layout.app')

@section('title', 'Thanh toán')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Thông tin khách hàng
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $e)
                                    <div>{{ $e }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('cart.placeOrder') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Họ tên</label>
                                <input type="text" name="fullname" value="{{ old('fullname') }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                    inputmode="numeric" pattern="[0-9]*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>

                            <div class="mb-3">
                                <label>Địa chỉ</label>
                                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Ghi chú</label>
                                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Phương thức thanh toán</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="cod"
                                        {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Thanh toán khi nhận hàng (COD)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="bank"
                                        {{ old('payment_method') == 'bank' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Chuyển khoản ngân hàng
                                    </label>
                                </div>
                            </div>

                            <button class="btn btn-success w-100">
                                Đặt hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Đơn hàng của bạn
                    </div>

                    <div class="card-body">
                        @php $total = 0; @endphp

                        @foreach ($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp

                            <div class="d-flex align-items-center border-bottom py-2">
                                <img src="{{ asset('storage/products/' . $item['thumbnail']) }}"
                                    style="width:70px; height:70px; object-fit:cover;" class="rounded border me-3">

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">
                                        Tên sản phẩm: {{ $item['proname'] }}
                                    </div>

                                    <div class="text-muted small">
                                        Số lượng: {{ $item['quantity'] }}
                                    </div>

                                    <div class="text-muted small">
                                        Đơn giá: {{ number_format($item['price']) }} đ
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="text-danger fw-bold">
                                        {{ number_format($subtotal) }} đ
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-3">
                            <h5>Tổng cộng</h5>
                            <h5 class="text-danger">
                                {{ number_format($total) }} đ
                            </h5>
                        </div>

                        <div class="mt-3 text-end">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
