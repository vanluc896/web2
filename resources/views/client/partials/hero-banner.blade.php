<section class="hero-banner mb-4 overflow-hidden">
    <div class="hero-orb hero-orb-one"></div>
    <div class="hero-orb hero-orb-two"></div>

    <div class="row align-items-center g-4 hero-banner-main p-4 p-lg-5">
        <div class="col-lg-7">
            <span class="hero-badge mb-3 d-inline-flex">Chào mừng đến với My Shop</span>
            <h1 class="hero-title mb-3">Sản phẩm đẹp, giá tốt, dễ lựa chọn</h1>
            <p class="hero-text mb-4">
                Cập nhật nhiều sản phẩm mới, ưu đãi hấp dẫn và mua sắm nhanh gọn ngay tại cửa hàng của chúng tôi.
            </p>
            <div class="d-flex flex-wrap gap-2 hero-actions">
                <button type="button" class="btn btn-warning px-4 hero-btn-main"
                    onclick="document.getElementById('product-sections')?.scrollIntoView({ behavior: 'smooth', block: 'start' })">
                    Xem sản phẩm
                </button>
                <a href="{{ route('cart.index') }}" class="btn btn-light px-4 hero-btn-sub">
                    Giỏ hàng
                </a>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="hero-panel">
                <div class="hero-panel-label">Ưu đãi nổi bật</div>
                <div class="hero-panel-price">Giảm đến 30%</div>
                <p class="hero-panel-text mb-4">
                    Nhiều sản phẩm đang có ưu đãi, giao diện thân thiện và đặt hàng nhanh gọn.
                </p>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <strong>Sản phẩm mới</strong>
                        <span>Cập nhật liên tục</span>
                    </div>
                    <div class="hero-stat">
                        <strong>Giá tốt</strong>
                        <span>Nhiều lựa chọn hợp lý</span>
                    </div>
                    <div class="hero-stat">
                        <strong>Đặt hàng dễ</strong>
                        <span>Không cần đăng nhập</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
