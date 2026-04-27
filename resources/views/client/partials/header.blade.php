<div class="bg-dark text-white p-3 d-flex justify-content-center align-items-center gap-5">

    {{-- Logo --}}
    <div>
        <a href="/" class="text-white text-decoration-none">
            <h4 class="m-0">My Shop</h4>
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('product.search') }}#product-sections" method="GET" class="d-flex" style="width: 30%;">
        <input type="text" name="keyword" class="form-control me-2"
            placeholder="Tìm sản phẩm..." value="{{ request('keyword') }}">
        <button class="btn btn-warning">Tìm</button>
    </form>

    {{-- Cart --}}
    <div>
        <a href="{{ route('cart.index') }}"
           class="text-white text-decoration-none d-flex align-items-center gap-2">

            <div class="position-relative">
                <i class="bi bi-cart3 fs-4 cart-icon"></i>

                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                    {{ count(session('cart', [])) }}
                </span>
            </div>

            <span>Giỏ hàng</span>
        </a>
    </div>

</div>
