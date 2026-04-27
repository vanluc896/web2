@extends('admin.layouts.app')
@section('title', 'Loại sản phẩm')
@section('content')
    <h3>Thêm loại sản phẩm</h3>

    {{-- Gọi component --}}
    <x-admin.panel-error />

    <form action="{{ route('ad.cate.store') }}" method="post" class="w-75" enctype="multipart/form-data">
        @csrf

        <label for="catename">Tên loại</label>
        <input type="text" name="catename" id="catename" class="form-control" value="{{ old('catename') }}">
        {{-- Hiển thị lỗi cho field catename --}}
        @error('catename')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="slug">slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
        {{-- Hiển thị lỗi cho field slug --}}
        @error('slug')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- ---------- --}}
        <div class="mb-3 img-group">
            <label for="thumbnail">Hình ảnh</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control img-input">
            {{-- -hiển thị ảnh preview --}}
            <div class="img-preview"></div>
            {{-- Hiển thị lỗi cho field thumbnail --}}
            @foreach ($errors->get('thumbnail') as $image)
                <div class="text-danger">{{ $image }}</div>
            @endforeach
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="status" value="1" id="status" checked>
            <label for="status" class="form-check-label">Hiển thị</label>
        </div>
        <label for="des">Mô tả cơ bản</label>
        <textarea name="des" id="des" class="form-control"></textarea>

        <div class="d-flex m-2">
            <a href="{{ route('ad.cate.index') }}" class="btn btn-info">&LeftArrowBar;</a>

            <input type="submit" value="Lưu" class="btn btn-warning">
            <input type="reset" value="Làm lại" class="btn btn-primary">
        </div>
    </form>

    <!-- <script>
        const brandNameInput = document.getElementById('catename');
        const slugInput = document.getElementById('slug');

        function createSlug(text) {
            return text
                .toLowerCase()
                .normalize('NFD') // tách dấu tiếng Việt
                .replace(/[\u0300-\u036f]/g, '') // xóa dấu
                .replace(/đ/g, 'd')
                .replace(/Đ/g, 'd')
                .replace(/[^a-z0-9\s-]/g, '') // xóa ký tự đặc biệt
                .trim()
                .replace(/\s+/g, '-') // khoảng trắng thành -
                .replace(/-+/g, '-'); // gộp nhiều dấu - thành 1
        }

        brandNameInput.addEventListener('input', function () {
            slugInput.value = createSlug(this.value);
        });
    </script> -->

@endsection

@section('scripts')
    @vite('resources/js/preview-image.js')
@endsection