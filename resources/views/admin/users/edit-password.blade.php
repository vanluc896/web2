<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@extends('admin.layouts.app')
@section('title', 'Cập nhật mật khẩu user')
@section('content')

<h3>Cập nhật mật khẩu user</h3>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

@if(session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif

<form action="{{ route('ad.users.updatePassword', $model->id) }}" method="POST" class="w-50">
    @csrf

    <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" class="form-control" value="{{ $model->username }}" disabled>
    </div>

    <div class="mb-3">
        <label for="current_password">Mật khẩu hiện tại</label>
        <div class="position-relative">
            <input type="password" name="current_password" id="current_password" class="form-control pe-5">
            <button type="button" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2"
                onclick="
                    const i=this.querySelector('i');
                    const inp=this.previousElementSibling;
                    inp.type=inp.type==='password'?'text':'password';
                    i.classList.toggle('bi-eye');
                    i.classList.toggle('bi-eye-slash'); ">
                <i class="bi bi-eye text-secondary"></i>
            </button>
        </div>
        @error('current_password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password">Mật khẩu mới</label>
        <div class="position-relative">
            <input type="password" name="password" id="password" class="form-control pe-5">
            <button type="button" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2"
                onclick="
                    const i=this.querySelector('i');
                    const inp=this.previousElementSibling;
                    inp.type=inp.type==='password'?'text':'password';
                    i.classList.toggle('bi-eye');
                    i.classList.toggle('bi-eye-slash'); ">
                <i class="bi bi-eye text-secondary"></i>
            </button>
        </div>
    </div>

    <div class="mb-3">
        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <div class="position-relative">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control pe-5">
            <button type="button" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2"
                onclick="
                    const i=this.querySelector('i');
                    const inp=this.previousElementSibling;
                    inp.type=inp.type==='password'?'text':'password';
                    i.classList.toggle('bi-eye');
                    i.classList.toggle('bi-eye-slash');">
                <i class="bi bi-eye text-secondary"></i>
            </button>
        </div>
    </div>
    <div class="mt-0 mb-3">
        <a href="{{ route('ad.forgot') }}" class="text-decoration-none small">
            Quên mật khẩu?
        </a>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
    <a href="{{ route('ad.users.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection


























































<!-- z@extends('admin.layouts.app')
@section('title', 'Cập nhật mật khẩu user')
@section('content')

<h3>Cập nhật mật khẩu user</h3>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

@if(session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif

<form action="{{ route('ad.users.updatePassword', $model->id) }}" method="POST" class="w-50">
    @csrf

    <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" class="form-control" value="{{ $model->username }}" disabled>
    </div>

    <div class="mb-3">
    <label>Mật khẩu hiện tại</label>
    <input type="password" name="current_password" class="form-control">

    @error('current_password')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

    <div class="mb-3">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-1">
        <label>Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
        <div class="mt-0">
    <a href="{{ route('ad.forgot') }}" class="text-decoration-none small ">
        Quên mật khẩu?
    </a>
</div>
    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>

    <a href="{{ route('ad.users.index') }}" class="btn btn-secondary">Quay lại</a>
</form>

@endsection -->