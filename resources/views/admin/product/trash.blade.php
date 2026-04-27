@extends('admin.layouts.app')
@section('title','Thùng rác sản phẩm')

@section('content')
<h3>
    Thùng rác sản phẩm
    <span class="badge bg-danger">{{ $trashCount }}</span>
</h3>

<a href="{{ route('ad.product.index2') }}" class="btn btn-primary mb-3">Quay lại danh sách</a>

<form action="" method="get" class="row mb-3">
    <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="Tên sản phẩm" value="{{ $keyword }}">
    </div>

    <div class="col-md-2">
        <input type="number" name="min_price" class="form-control" placeholder="Giá từ" value="{{ $min_price }}">
    </div>

    <div class="col-md-2">
        <input type="number" name="max_price" class="form-control" placeholder="Giá đến" value="{{ $max_price }}">
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">-- Sắp xếp --</option>
            <option value="name_asc" {{ $sort=='name_asc'?'selected':'' }}>Tên A-Z</option>
            <option value="name_desc" {{ $sort=='name_desc'?'selected':'' }}>Tên Z-A</option>
            <option value="price_asc" {{ $sort=='price_asc'?'selected':'' }}>Giá tăng dần</option>
            <option value="price_desc" {{ $sort=='price_desc'?'selected':'' }}>Giá giảm dần</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Tìm</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <td>Mã</td>
            <td>Tên sản phẩm</td>
            <td>Hình ảnh</td>
            <td>Giá</td>
            <td>Loại SP</td>
            <td>Thương hiệu</td>
            <td>Đã xóa lúc</td>
            <td width="300">Thao tác</td>
        </tr>
    </thead>
<tbody>
    @forelse ($products as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->proname }}</td>
        <td>
            <img src="{{ asset('storage/products/' . $p->thumbnail) }}" width="100" class="img-thumbnail">
        </td>
        <td>{{ number_format($p->price) }}</td>
        <td>{{ $p->category->catename ?? '' }}</td>
        <td>{{ $p->brand->brandname ?? '' }}</td>
        <td>{{ $p->deleted_at }}</td>
        <td>
            <form action="{{ route('ad.product.restore', $p->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Khôi phục</button>
            </form>

            <form action="{{ route('ad.product.forceDelete', $p->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                    onclick="return confirm('Xóa vĩnh viễn sản phẩm này?')">
                    Xóa vĩnh viễn
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="text-center text-muted">
            Sản phẩm trống
        </td>
    </tr>
    @endforelse
</tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
    <form action="" method="get">
        <input type="hidden" name="keyword" value="{{ $keyword }}">
        <input type="hidden" name="min_price" value="{{ $min_price }}">
        <input type="hidden" name="max_price" value="{{ $max_price }}">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <select name="limit" class="form-select" onchange="this.form.submit()">
            <option value="5" {{ $limit == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>

    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection