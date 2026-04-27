
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}"> -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="shadow p-4 mx-auto" style="width: 500px;">
            <h3>Đăng nhập hệ thống</h3>
            {{--hiển thị lỗi --}}
            <x-admin.panel-error/>
            <form action="{{ route('ad.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    {{-- Có thể đăng nhập theo username hoặc email --}}
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" 
                        placeholder="" name="username" value="{{ old('username') }}">
                </div>

                <!-- gốc -->
                <!-- <div class="mb-3">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" id="password"
                        placeholder="Nhập mật khẩu" name="password" value="{{ old('password') }}">
                </div> -->

                <!-- <div class="mb-3 position-relative">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control pe-5" id="password" placeholder="Nhập mật khẩu" name="password">
                    <button type="button"
                        style="position:absolute; right:10px; top:70%; transform:translateY(-50%); border:none; background:none;"
                        onclick="
                        this.querySelector('i').classList.toggle('bi-eye'); 
                        this.querySelector('i').classList.toggle('bi-eye-slash'); 
                        password.type = password.type==='password' ? 'text' : 'password'">
                        <i class="bi bi-eye text-secondary"></i>
                    </button>
                </div> -->

                     <div class="mb-3">
                        <label for="password">Mật khẩu</label>

                        <div class="position-relative">
                            <input type="password" class="form-control pe-5" id="password" name="password">

                            <button type="button"
                                class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2"
                                onclick="
                                    const i=this.querySelector('i');
                                    const inp=this.previousElementSibling;
                                    inp.type=inp.type==='password'?'text':'password';
                                    i.classList.toggle('bi-eye');
                                    i.classList.toggle('bi-eye-slash');
                                ">
                                <i class="bi bi-eye text-secondary"></i>
                            </button>
                        </div>
                    </div>


                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                </div>

                <div class="d-flex m-2 gap-2 justify-content-center">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    <a href="{{ route('ad.forgot') }}" class="btn btn-warning">Quên mật khẩu</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
