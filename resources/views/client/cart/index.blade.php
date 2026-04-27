@extends('client.layout.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="m-0">Giỏ hàng</h3>

        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            Tiếp tục mua hàng
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (empty($cart))
        <div class="alert alert-warning">
            Giỏ hàng đang trống
        </div>
    @else
        <form action="{{ route('cart.updateAll') }}" method="POST" id="cart-form">
            @csrf

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="80">STT</th>
                            <th width="200">Tên sản phẩm</th>
                            <th width="100">Ảnh</th>
                            <th width="150">Giá</th>
                            <th width="170">Số lượng</th>
                            <th width="170">Thành tiền</th>
                            <th width="110">Xóa</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $total = 0; @endphp

                        @foreach ($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp

                            <tr>
                                <td class="align-middle fw-semibold">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="align-middle text-center">
                                    @if (!empty($item['slug']))
                                        <a href="{{ route('product.show', $item['slug']) }}"
                                            class="text-decoration-none text-dark fw-semibold">
                                            {{ $item['proname'] }}
                                        </a>
                                    @else
                                        {{ $item['proname'] }}
                                    @endif
                                </td>

                                <td class="align-middle text-center">
                                    <img src="{{ asset('storage/products/' . $item['thumbnail']) }}" alt="{{ $item['proname'] }}"
                                        style="width:80px; height:70px; object-fit:cover;" class="rounded border d-block mx-auto">
                                </td>

                                <td class="text-danger fw-bold align-middle item-price" data-price="{{ $item['price'] }}">
                                    {{ number_format($item['price']) }} đ
                                </td>

                                <td class="align-middle">
                                    <input type="number" name="quantities[{{ $item['productid'] }}]" min="1"
                                        value="{{ $item['quantity'] }}" class="form-control text-center mx-auto"
                                        style="width:90px;">
                                </td>

                                <td class="fw-bold text-success align-middle item-subtotal" data-subtotal="{{ $subtotal }}">
                                    {{ number_format($subtotal) }} đ
                                </td>

                                <td class="align-middle">
                                    <a href="{{ route('cart.remove', $item['productid']) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="table-light">
                            <th colspan="5" class="text-center align-middle">Tổng cộng</th>
                            <th colspan="2" class="text-danger fs-5 align-middle" id="cart-total" data-total="{{ $total }}">
                                {{ number_format($total) }} đ
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Cập nhật giỏ hàng
                    </button>

                    <a href="{{ route('cart.clear') }}" class="btn btn-danger"
                        onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                        Xóa toàn bộ giỏ hàng
                    </a>
                </div>

                <a href="{{ route('cart.checkout') }}" class="btn btn-success">
                    Tiến hành đặt hàng
                </a>
            </div>
        </form>
    @endif
@endsection
