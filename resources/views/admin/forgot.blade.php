
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Forgot</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="shadow p-4 mx-auto" style="width: 500px;">
            <h3>Quên mật khẩu</h3>
            <x-admin.panel-error />
            <form method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control"  id="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="d-flex m-2 gap-2 justify-content-center flex-wrap">
                    <!-- Mật khẩu mới -->
                    <button type="submit" formaction="{{ route('ad.forgot') }}"class="btn btn-primary">
                        Gửi mật khẩu mới
                    </button>

                    <!-- Link reset -->
                    <button type="submit" formaction="{{ route('ad.forgot.link') }}"class="btn btn-success">
                        Gửi link reset
                    </button>
                    <a href="{{ route('ad.login') }}" class="btn btn-warning">
                        Đăng nhập lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>




















































<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Forgot</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="shadow p-4 mx-auto" style="width: 500px;">
            <h3>Quên mật khẩu</h3>
            {{-- Gọi component - hiển thị lỗi --}}
            <x-admin.panel-error />

            <!-- thêm .link -->
            <form action="{{ route('ad.forgot.link') }}" method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="" name="email"
                        value="{{ old('email') }}"></div>
                <div class="d-flex m-2 gap-2 justify-content-center">
                    <!-- đổi gửi email thành gửi link reset -->
                    <button type="submit" class="btn btn-primary">Gửi link reset</button>
                    <a href="{{ route('ad.login') }}" class="btn btn-warning">Đăng nhập lại</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> -->

