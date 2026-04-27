@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    @if (session('message'))
        <div class="d-flex justify-content-center mt-3">
            <div class="alert alert-success alert-dismissible fade show w-50 text-center shadow-sm rounded-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @php
        $user = auth()->user();
    @endphp

    <div class="mb-4">
        <div class="p-4 rounded-4 shadow-sm bg-white border">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard</h2>
                    <p class="text-muted mb-0">
                        Xin chào, {{ $user->fullname ?? $user->username }}
                        @if ($user->role == 1)
                            chào mừng bạn quay lại hệ thống quản trị.
                        @else
                            chào mừng bạn quay lại. Bạn có thể quản lý tài khoản và thực hiện các thao tác được cấp quyền.
                        @endif
                    </p>
                </div>
                <div class="mt-3 mt-md-0">
                    @if ($user->role == 1)
                        <span class="badge bg-danger fs-6 px-3 py-2">Admin</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2">User</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($user->role == 1)
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted mb-1">Người dùng</div>
                            <h3 class="fw-bold mb-0">{{ \App\Models\User::count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted mb-1">Sản phẩm</div>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Product::count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="bi bi-box-seam fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted mb-1">Danh mục</div>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Category::count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="bi bi-grid-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted mb-1">Bài viết</div>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Post::count() }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="bi bi-file-earmark-text-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted mb-1">Thương hiệu</div>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Brand::count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="bi bi-award-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold mb-1">Quản trị nhanh</h5>
                        <p class="text-muted small mb-0">Truy cập nhanh các chức năng thường dùng</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('ad.product.index2') }}" class="text-decoration-none">
                                    <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                        <div class="fw-semibold text-dark">Quản lý sản phẩm</div>
                                        <div class="text-muted small">Xem danh sách, sửa và cập nhật sản phẩm</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ad.cate.index') }}" class="text-decoration-none">
                                    <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                        <div class="fw-semibold text-dark">Quản lý danh mục</div>
                                        <div class="text-muted small">Theo dõi và chỉnh sửa loại sản phẩm</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ad.brands.index') }}" class="text-decoration-none">
                                    <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                        <div class="fw-semibold text-dark">Quản lý thương hiệu</div>
                                        <div class="text-muted small">Cập nhật thương hiệu hiển thị trên shop</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ad.posts.index') }}" class="text-decoration-none">
                                    <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                        <div class="fw-semibold text-dark">Quản lý bài viết</div>
                                        <div class="text-muted small">Theo dõi nội dung bài viết và tin tức</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ad.users.index') }}" class="text-decoration-none">
                                    <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                        <div class="fw-semibold text-dark">Quản lý người dùng</div>
                                        <div class="text-muted small">Xem và chỉnh sửa thông tin tài khoản</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold mb-1">Thông tin tài khoản</h5>
                        <p class="text-muted small mb-0">Thông tin đăng nhập hiện tại</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="text-muted small">Họ tên</div>
                            <div class="fw-semibold">{{ $user->fullname ?? 'Chưa cập nhật' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Tên đăng nhập</div>
                            <div class="fw-semibold">{{ $user->username }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ $user->email }}</div>
                        </div>
                        <div>
                            <div class="text-muted small">Vai trò</div>
                            <span class="badge bg-danger px-3 py-2">Admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="dashboard-latest-section mt-4">
            <div class="dashboard-latest-heading dashboard-latest-heading-blue">
                <h5 class="mb-0">Sản phẩm mới nhất</h5>
            </div>
            <div class="row g-4 mt-1">
                @forelse ($latestProducts as $product)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="dashboard-latest-card">
                            <div class="dashboard-latest-image-wrap">
                                <img src="{{ asset('storage/products/' . ($product->thumbnail ?? 'default.png')) }}"
                                    alt="{{ $product->proname }}" class="dashboard-latest-image">
                            </div>
                            <div class="dashboard-latest-body">
                                <h6 class="dashboard-latest-title">{{ $product->proname }}</h6>
                                <div class="dashboard-latest-price">{{ number_format($product->price) }} đ</div>
                                <div class="dashboard-latest-meta">Ngày thêm: {{ $product->created_at?->format('d/m/Y') }}</div>
                            </div>
                            <div class="dashboard-latest-actions">
                                <a href="{{ route('ad.product.edit', ['id' => $product->id]) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye-fill"></i> Xem chi tiết
                                </a>
                                <a href="{{ route('ad.product.index2') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-grid-fill"></i> Quản lý
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">Chưa có sản phẩm nào.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="dashboard-latest-section mt-4">
            <div class="dashboard-latest-heading dashboard-latest-heading-orange">
                <h5 class="mb-0">Đơn hàng mới nhất</h5>
            </div>
            <div class="row g-4 mt-1">
                @forelse ($latestOrders as $order)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="dashboard-latest-card">
                            <div class="dashboard-latest-order-header">
                                <span class="dashboard-order-code">{{ $order->order_code }}</span>
                            </div>
                            <div class="dashboard-latest-body">
                                <h6 class="dashboard-latest-title">{{ $order->customer->fullname ?? 'Khách vãng lai' }}</h6>
                                <div class="dashboard-latest-price">{{ number_format($order->total_amount) }} đ</div>
                                <div class="dashboard-latest-meta">Ngày đặt: {{ $order->created_at?->format('d/m/Y') }}</div>
                                <span
                                    class="badge mt-2 {{ $order->status === 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="dashboard-latest-actions">
                                <a href="{{ route('ad.order.show', ['id' => $order->id]) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye-fill"></i> Xem chi tiết
                                </a>
                                <a href="{{ route('ad.order.index') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-list-ul"></i> Quản lý
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">Chưa có đơn hàng nào.</div>
                    </div>
                @endforelse
            </div>
        </section>
    @else
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('ad.users.editPassword', $user->id) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card text-center">
                        <div class="card-body p-4">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width:60px;height:60px;">
                                <i class="bi bi-shield-lock fs-3"></i>
                            </div>
                            <div class="fw-semibold fs-5 text-dark">Đổi mật khẩu</div>
                            <div class="text-muted small mt-1">
                                Cập nhật mật khẩu để bảo mật tài khoản
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width:60px;height:60px;">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <div class="fw-semibold fs-5">Hoạt động</div>
                        <div class="text-muted small mt-1">
                            Bạn đã đăng nhập thành công vào hệ thống
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width:60px;height:60px;">
                            <i class="bi bi-check-circle fs-3"></i>
                        </div>
                        <div class="fw-semibold fs-5">Trạng thái</div>
                        <div class="text-muted small mt-1">
                            Tài khoản của bạn đang hoạt động bình thường
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                            <h5 class="fw-bold mb-1">Quản trị nhanh</h5>
                            <p class="text-muted small mb-0">Truy cập nhanh các chức năng thường dùng</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('ad.product.index2') }}" class="text-decoration-none">
                                        <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                            <div class="fw-semibold text-dark">Xem sản phẩm</div>
                                            <div class="text-muted small">Xem danh sách, sửa và cập nhật sản phẩm</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('ad.cate.index') }}" class="text-decoration-none">
                                        <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                            <div class="fw-semibold text-dark">Xem danh mục</div>
                                            <div class="text-muted small">Xem và lựa chọn các loại sản phẩm</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('ad.brands.index') }}" class="text-decoration-none">
                                        <div class="border rounded-4 p-3 h-100 bg-light hover-card">
                                            <div class="fw-semibold text-dark">Xem thương hiệu</div>
                                            <div class="text-muted small">Xem và lựa chọn các thương hiệu có trên shop</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                            <h5 class="fw-bold mb-1">Thông tin tài khoản</h5>
                            <p class="text-muted small mb-0">Thông tin đăng nhập hiện tại</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <div class="text-muted small">Họ tên</div>
                                <div class="fw-semibold">{{ $user->fullname ?? 'Chưa cập nhật' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Tên đăng nhập</div>
                                <div class="fw-semibold">{{ $user->username }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Email</div>
                                <div class="fw-semibold">{{ $user->email }}</div>
                            </div>
                            <div>
                                <div class="text-muted small">Vai trò</div>
                                <span class="badge bg-secondary px-3 py-2">User</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
