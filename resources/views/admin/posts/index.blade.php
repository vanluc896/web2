@extends('admin.layouts.app')
@section('title', 'Bài viết')
@section('content')

<h3>Danh sách bài viết</h3>

@include('components.admin.panel-error')

<a href="{{ route('ad.posts.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

<form action="" method="get" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control"
            placeholder="Tiêu đề bài viết"
            value="{{ $keyword }}">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Tìm</button>
    </div>
</form>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <td width="50">ID</td>
            <td>Ảnh</td>
            <td>Tiêu đề</td>
            <td>Slug</td>
            <td width="150">Người đăng</td>
            <td>Trạng thái</td>
            <td width='150'></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($posts as $po)
            <tr>
                <td>{{ $po->id }}</td>
                <td>
                    <img src="{{ asset('storage/posts/' . ($po->image ?: 'default.png')) }}" alt="{{ $po->title }}"
                        width="90" class="img-thumbnail">
                </td>
                <td>{{ $po->title }}</td>
                <td>{{ $po->slug }}</td>
                <td>{{ $po->user->fullname ?? $po->user->username ?? 'N/A' }}</td>
                <td>{{ $po->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
                <td>
                    <a href="{{ route('ad.posts.edit', ['id' => $po->id]) }}" class="btn btn-warning">Sửa</a>

                    <form action="{{ route('ad.posts.del', ['id' => $po->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
    <form action="" method="get">
        <input type="hidden" name="keyword" value="{{ $keyword }}">

        <select style="margin-top: -35px !important;" name="limit" class="form-select" onchange="this.form.submit()">
            <option value="5" {{ $limit == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>

    {{ $posts->links('pagination::bootstrap-5') }}
</div>

@endsection
