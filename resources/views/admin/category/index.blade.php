@extends('admin.layouts.app')
@section('title','Loại sản phẩm')
@section('content')
<h3>Danh sách loại sản phẩm</h3>
<a href="{{ route('ad.cate.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
<a href="{{ route('ad.cate.trash') }}" class="btn btn-secondary mb-3 d-inline-flex align-items-center gap-2 trash-btn">
    <span class="trash-icon-wrap">
        <i class="bi bi-trash"></i>

        @if($trashCount >= 0)
            <span class="trash-count">{{ $trashCount }}</span>
        @endif
    </span>

    <span>Thùng rác</span>
</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>Mã</td>
            <td>Tên</td>
            <td>Hình ảnh</td>
            <td>Trạng thái</td>
            <td></td>
        </tr>
    </thead>
    <tbody>

        @foreach ($list as $item)
         <tr>
            <td>{{ $item->cateid }}</td>
            <td>{{ $item->catename }}</td>

            {{-- --- --}}
            <td>
                <img src="{{ asset('storage/categories/' . $item->thumbnail) }}"
                width="100" class="img-thumbnail">
            </td>
            <td>
                <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->status ? 'Hiển thị' : 'Ẩn' }}
                </span>
            </td>

            <td>
                <a href="{{ route('ad.cate.edit',['id'=>$item->cateid]) }}" class="btn btn-warning">Sửa</a>
                <form action="{{ route('ad.cate.del', $item->cateid) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Xóa">
                </form>
            </td>
        </tr>
        @endforeach
       
    </tbody>
</table>
{{ $list->links('pagination::bootstrap-5') }}
@endsection