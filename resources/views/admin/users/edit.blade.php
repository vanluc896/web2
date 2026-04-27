@extends('admin.layouts.app')
@section('title', 'Sua user')
@section('content')

<h3>Sửa thông tin user</h3>

@include('components.admin.panel-error')

<form action="{{ route('ad.users.update', $model->id) }}" method="post" class="w-75">
    @csrf
    @method('PUT')

    <label for="staff_code">Mã nhân viên</label>
    <input type="text" name="staff_code" id="staff_code" class="form-control" value="{{ old('staff_code', $model->staff_code) }}">
    @error('staff_code')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="username">Tên đăng nhập</label>
    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $model->username) }}">
    @error('username')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="fullname">Họ và tên</label>
    <input type="text" name="fullname" id="fullname" class="form-control" value="{{ old('fullname', $model->fullname) }}">
    @error('fullname')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $model->email) }}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="password">Password mới</label>
    <input type="password" name="password" id="password" class="form-control">
    @error('password')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="role">Quyền</label>
    <select name="role" id="role" class="form-control">
        <option value="0" @selected(old('role', (string) $model->role) == '0')>User</option>
        <option value="1" @selected(old('role', (string) $model->role) == '1')>Admin</option>
    </select>
    @error('role')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="d-flex m-2">
        <a href="{{ route('ad.users.index') }}" class="btn btn-info">&LeftArrowBar;</a>
        <input type="submit" value="Lưu" class="btn btn-warning">
        <input type="reset" value="Làm lại" class="btn btn-primary">
    </div>
</form>

@endsection
