@extends('admin.layouts.app')
@section('title','Các thương hiệu')
@section('content')
<h3>Danh sách các thương hiệu</h3>
<a href="{{ route('ad.brands.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
<a href="{{ route('ad.brands.trash') }}" class="btn btn-secondary mb-3 d-inline-flex align-items-center gap-2 trash-btn">
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
            <td>Thao tác</td>
        </tr>
    </thead>
    <tbody>

        @foreach ($brands as $b)
         <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->brandname }}</td>
            {{-- --- --}}
            <td>
                <img src="{{ asset('storage/brands/' . $b->thumbnail) }}"
                width="100" class="img-thumbnail">
            </td>
            <td>
                <span class="badge {{ $b->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $b->status ? 'Hiển thị' : 'Ẩn' }}
                </span>
            </td>
            <td>
                <a href="{{ route('ad.brands.edit',['id'=>$b->id]) }}" class="btn btn-warning" style="display:inline-block;">Sửa</a>
                <form action="{{ route('ad.brands.del', $b->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Xóa">
                </form>
        </tr>
        @endforeach
       
    </tbody>
</table>
{{ $brands->links('pagination::bootstrap-5') }}
@endsection