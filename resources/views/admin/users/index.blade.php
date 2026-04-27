@extends('admin.layouts.app')
@section('title','Danh sach nguoi dung')
@section('content')

<h3>Danh sách người dùng</h3>
@include('components.admin.panel-error')

<a href="{{ route('ad.users.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <td>Id</td>
            <td>Mã nhân viên</td>
            <td>Tên đăng nhập</td>
            <td>Họ tên</td>
            <td>Email</td>
            <td>Quyền</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->staff_code }}</td>
            <td>{{ $u->username }}</td>
            <td>{{ $u->fullname }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role == 1 ? 'Admin' : 'User' }}</td>
            <td>
                <a href="{{ route('ad.users.edit', ['id' => $u->id]) }}" class="btn btn-warning">Sửa</a>


                <form action="{{ route('ad.users.del', ['id' => $u->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Bạn có chắc muốn xóa user này?')">
                        Xóa
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links('pagination::bootstrap-5') }}
@endsection
