<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="shadow p-4 mx-auto" style="width: 500px;">

        <h3 class="text-center mb-4">Đặt lại mật khẩu</h3>

        {{-- Hiển thị lỗi chung --}}
        <x-admin.panel-error />

        {{-- Hiển thị message --}}
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('ad.reset.password') }}" method="POST">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control">

                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="d-flex gap-2 justify-content-center mt-3">
                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                <a href="{{ route('ad.login') }}" class="btn btn-warning"> Đăng nhập</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>