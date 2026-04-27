@extends('client.layout.app')

@section('title', $title)

@section('content')
    @include('client.partials.hero-banner')

    <h3 id="product-sections" class="my-4">{{ $title }}</h3>

    <form action="{{ url()->current() }}#product-sections" method="get" class="row g-2 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..."
                value="{{ $keyword }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">Giá từ</label>
            <input type="number" name="min_price" class="form-control" value="{{ $min_price }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">Giá đến</label>
            <input type="number" name="max_price" class="form-control" value="{{ $max_price }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Sắp xếp</label>
            <select name="sort" class="form-select">
                <option value="">Mới nhất</option>
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

    <div class="row">
        @forelse ($products as $item)
            <div class="col-md-3 mb-4">
                <x-client.product :product="$item" />
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Không có sản phẩm nào.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <form action="{{ url()->current() }}#product-sections" method="get">
            <input type="hidden" name="keyword" value="{{ $keyword }}">
            <input type="hidden" name="min_price" value="{{ $min_price }}">
            <input type="hidden" name="max_price" value="{{ $max_price }}">
            <input type="hidden" name="sort" value="{{ $sort }}">

            <select name="limit" class="form-select" onchange="this.form.submit()">
                <option value="8" {{ $limit == 8 ? 'selected' : '' }}>8</option>
                <option value="12" {{ $limit == 12 ? 'selected' : '' }}>12</option>
                <option value="16" {{ $limit == 16 ? 'selected' : '' }}>16</option>
            </select>
        </form>

        {{ $products->links() }}
    </div>
@endsection
