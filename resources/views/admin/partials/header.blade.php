<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar admin-header bg-white shadow-sm px-3 px-md-4">
    <div class="container-fluid d-flex justify-content-between align-items-center flex-nowrap">

        {{-- Logo / tiêu đề --}}
        <span class="fw-bold fs-5 fs-md-4 text-dark text-truncate me-2">
            Admin Panel
        </span>

        {{-- Bên phải --}}
        <div class="d-flex align-items-center flex-shrink-0">

            {{-- Xin chào: ẩn trên màn hình nhỏ --}}
            <div class="text-end me-2 me-md-4 d-none d-sm-block">
                <div class="small text-muted">Xin chào</div>
                <div class="fw-semibold text-truncate" style="max-width: 160px;">
                    {{ Auth::user()->fullname }}
                </div>
            </div>

            {{-- Dropdown --}}
            <div class="dropdown">
                <button class="btn admin-user-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 p-2">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <div class="fw-semibold">{{ Auth::user()->fullname }}</div>
                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                    </li>

                    <li>
                        <a class="dropdown-item rounded-3 py-2" href="{{ route('ad.users.editPassword', Auth::id()) }}">
                            <i class="bi bi-key me-2 text-warning"></i>
                            Đổi mật khẩu
                        </a>
                    </li>

                    <li>
                        <form action="{{ route('ad.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-3 py-2">
                                <i class="bi bi-box-arrow-right me-2 text-danger"></i>
                                Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</nav>