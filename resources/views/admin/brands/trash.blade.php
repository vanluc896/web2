@extends('admin.layouts.app')
@section('title','Thùng rác thương hiệu')

@section('content')
<h3>
    Thùng rác thương hiệu
    <span class="badge bg-danger">{{ $trashCount }}</span>
</h3>

<a href="{{ route('ad.brands.index') }}" class="btn btn-primary mb-3">Quay lại danh sách</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <td>Mã</td>
            <td>Tên</td>
            <td>Hình ảnh</td>
            <td>Đã xóa lúc</td>
            <td width="300">Thao tác</td>
        </tr>
    </thead>
    <tbody>
<tbody>
    @forelse ($brands as $b)
    <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->brandname }}</td>
        <td>
            <img src="{{ asset('storage/brands/' . $b->thumbnail) }}" width="100" class="img-thumbnail">
        </td>
        <td>{{ $b->deleted_at }}</td>
        <td>
            <form action="{{ route('ad.cate.restore', $b->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Khôi phục</button>
            </form>

            <form action="{{ route('ad.cate.forceDelete', $b->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn mục này?')">
                    Xóa vĩnh viễn
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center text-muted">
            Loại sản phẩm trống
        </td>
    </tr>
    @endforelse
</tbody>
</table>

{{ $brands->links('pagination::bootstrap-5') }}
@endsection