<div class="admin-sidebar bg-dark text-white p-3" id="sidebar">
    <div class="sidebar-resizer" id="sidebarResizer"></div>

    <h4 class="mb-4">Admin</h4>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ad.dashboard') ? 'active' : '' }}"
                href="{{ route('ad.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (auth()->user()->role == 1)
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.cate.*') ? 'active' : '' }}"
                    href="{{ route('ad.cate.index') }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Loại sản phẩm</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.product.*') ? 'active' : '' }}"
                    href="{{ route('ad.product.index2') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.brands.*') ? 'active' : '' }}"
                    href="{{ route('ad.brands.index') }}">
                    <i class="bi bi-bookmark-star-fill"></i>
                    <span>Thương hiệu</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.users.*') ? 'active' : '' }}"
                    href="{{ route('ad.users.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Người dùng</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.posts.*') ? 'active' : '' }}"
                    href="{{ route('ad.posts.index') }}">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Bài viết</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.order.*') ? 'active' : '' }}"
                    href="{{ route('ad.order.index') }}">
                    <i class="bi bi-receipt"></i>
                    <span>Đơn hàng</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ad.customers.*') ? 'active' : '' }}"
                    href="{{ route('ad.customers.index') }}">
                    <i class="bi bi-person-vcard"></i>
                    <span>Khách hàng</span>
                </a>
            </li>
        @endif
    </ul>
</div>
