@extends('admin.layouts.app')
@section('title', 'Sản phẩm')
@section('content')
    <h3>Danh sách sản phẩm</h3>
    <a href="{{ route('ad.product.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
<a href="{{ route('ad.product.trash') }}" class="btn btn-secondary mb-3 d-inline-flex align-items-center gap-2 trash-btn">
    <span class="trash-icon-wrap">
        <i class="bi bi-trash"></i>

        @if($trashCount >= 0)
            <span class="trash-count">{{ $trashCount }}</span>
        @endif
    </span>

    <span>Thùng rác</span>
</a>
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
                    <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                    <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
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
                    <td>Gía</td>
                    <td>Loại SP</td>
                    <td>Thương hiệu</td>
                    <td>Thao tác</td>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->proname }}</td>
                        <td>
                            <img src="{{ asset('storage/products/' . $p->thumbnail) }}" width="100" class="img-thumbnail">
                        </td>
                        <td>{{ number_format($p->price) }}</td>
                        <td>{{ $p->category->catename}}</td>
                        <td>{{ $p->brand->brandname}}</td>
                        <td>
                            <a href="{{ route('ad.product.edit', ['id' => $p->id]) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('ad.product.del', $p->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa không?')">
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
                <select style="    margin-top: -35px !important;" name="limit" id="" class="form-select"
                    onchange="this.form.submit()">
                    <option value="5" {{ $limit == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
@endsection