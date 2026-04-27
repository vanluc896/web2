@extends('admin.layouts.app')
@section('title','Thùng rác loại sản phẩm')

@section('content')
<h3>
    Thùng rác loại sản phẩm
    <span class="badge bg-danger">{{ $trashCount }}</span>
</h3>

<a href="{{ route('ad.cate.index') }}" class="btn btn-primary mb-3">Quay lại danh sách</a>

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
    @forelse ($list as $item)
    <tr>
        <td>{{ $item->cateid }}</td>
        <td>{{ $item->catename }}</td>
        <td>
            <img src="{{ asset('storage/categories/' . $item->thumbnail) }}" width="100" class="img-thumbnail">
        </td>
        <td>{{ $item->deleted_at }}</td>
        <td>
            <form action="{{ route('ad.cate.restore', $item->cateid) }}" method="POST" style="display:inline-block">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Khôi phục</button>
            </form>

            <form action="{{ route('ad.cate.forceDelete', $item->cateid) }}" method="POST" style="display:inline-block">
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

{{ $list->links('pagination::bootstrap-5') }}
@endsection