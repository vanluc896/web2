<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="card product-card h-100 shadow-sm border-0">
    <img src="{{ asset('storage/products/' . $product->thumbnail) }}" class="card-img-top product-img">
    <div class="card-body text-center d-flex flex-column">
        <h6 class="card-title mb-2">
            {{ $product->proname }}
        </h6>

        @if (!empty($product->sale_price) && $product->sale_price < $product->price)
            <p class="text-danger fw-bold mb-1">
                {{ number_format($product->sale_price) }}đ
            </p>
            <p class="text-muted text-decoration-line-through small mb-3">
                {{ number_format($product->price) }}đ
            </p>
        @else
            <p class="text-danger fw-bold mb-3">
                {{ number_format($product->price) }}đ
            </p>
        @endif

        <div class="mt-auto d-flex gap-2">
            <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                class="btn btn-outline-primary btn-sm flex-fill">
                <i class="fa fa-eye me-1"></i> Xem chi tiết
            </a>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="js-add-to-cart flex-fill">
                @csrf
                <button type="submit" class="btn btn-success btn-sm w-100">
                    <i class="fa fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                </button>
            </form>

        </div>

    </div>
</div>
