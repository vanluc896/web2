@extends('client.layout.app')
@section('title', 'Chi tiet san pham')

@section('content')
    <div class="d-flex justify-content-between align-items-center my-3">
        <a href="{{ route('home') }}" class="btn btn-warning">
            Quay lại
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <img src="{{ asset('storage/products/' . $product->thumbnail) }}" class="img-fluid rounded border"
                alt="{{ $product->proname }}">
        </div>

        <div class="col-md-7">
            <h2>{{ $product->proname }}</h2>

            @if (!empty($product->sale_price) && $product->sale_price < $product->price)
                <p class="text-danger fs-4 fw-bold mb-1">
                    {{ number_format($product->sale_price) }}đ
                </p>
                <p class="text-muted text-decoration-line-through">
                    {{ number_format($product->price) }}đ
                </p>
            @else
                <p class="text-danger fs-4 fw-bold">
                    {{ number_format($product->price) }}đ
                </p>
            @endif

            <div class="mb-3">
                <div class="mb-2">
                    <span class="fw-semibold">Loại sản phẩm:</span>
                    <a href="{{ route('product.category', $product->category->slug) }}" class="text-decoration-none">
                        {{ $product->category->catename }}
                    </a>
                </div>
                <div>
                    <span class="fw-semibold">Thương hiệu:</span>
                    <a href="{{ route('product.brand', $product->brand->slug) }}" class="text-decoration-none">
                        {{ $product->brand->brandname }}
                    </a>
                </div>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="js-add-to-cart">
                @csrf
                <button class="btn btn-success">
                    Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>

    <div class="mt-4 border rounded p-3">
        <h5 class="fw-bold mb-3 border-bottom pb-2">
            Mô tả sản phẩm
        </h5>
        <div style="line-height: 1.8;">
            {!! $product->description !!}
        </div>
    </div>
@endsection
