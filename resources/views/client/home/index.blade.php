@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('client.layout.app')
@section('title', 'Trang chủ')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @include('client.partials.hero-banner')
    <div id="product-sections" class="card-header bg-primary text-white my-3 p-2">
        Sản phẩm mới nhất
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($newProducts as $item)
                <div class="col-md-3 mb-4">
                    <x-client.product :product="$item" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="card-header bg-warning text-white my-3 p-2">
        Sản phẩm giảm giá
    </div>
    <div class="card-body">
        <div class="row">
            @forelse ($saleProducts as $item)
                <div class="col-md-3 mb-4">
                    <x-client.product :product="$item" />
                </div>
            @empty
                <div class="col-12">
                    <div class="btn btn-warning mb-0">
                        Chưa có sản phẩm giảm giá
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="card-header bg-danger text-white my-3 p-2">
        Sản phẩm bán chạy
    </div>
    <div class="card-body">
        <div class="row">
            @forelse ($bestProducts as $item)
                <div class="col-md-3 mb-4">
                    <x-client.product :product="$item" />
                </div>
            @empty
                <div class="col-12">
                    <div class="btn btn-warning mb-0">
                        Chưa có sản phẩm bán chạy
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
