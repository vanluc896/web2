@extends('admin.layouts.app')
@section('title', 'Sản phẩm - Thêm')
@section('content')

<form action="{{ route('ad.product.store') }}" method="post" class="m-auto w-auto border p-3" enctype="multipart/form-data">
    @csrf

    <h3>Thêm sản phẩm</h3>

        {{--Hiển thị lỗi khi validate không thành công --}}
    @if($errors->any())
        <p class="alert alert-danger">
            @foreach($errors->all() as $e)
            {{$e }} <br>
            @endforeach
        </p>
    @endif

    {{-- Hiển thị thực hiện insert thất bại
    Đọc session flash --}}
    @if(session('message'))
    <p class="alert alert-danger">{{ session('message') }}</p>
    @endif
    

    <div class="mb-3">
        <label for="proname">Tên sản phẩm</label>
        <input type="text" name="proname" id="proname" class="form-control" value="{{ old('proname') }}">
    </div>
    {{-- Hiển thị lỗi cho field proname --}}
    @error('proname')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="slug">slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
    </div>
    {{-- Hiển thị lỗi cho field slug --}}
    @error('slug')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="price">Giá</label>
        <input type="number" name="price" class="form-control w-50" value="{{ old('price') }}">
    </div>
        @error('price')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- Dropdown loại sản phẩm, thương hiệu --}}
    <div class="row">
        <div class="col-6 mb-3">
            <label>Danh mục</label>
            <select name="cateid" class="form-control">
                <option selected disabled>-- Chọn danh mục --</option>
                @foreach($categories as $cate)
                    <option value="{{ $cate->cateid }}">
                        {{ $cate->catename }}
                    </option>
                @endforeach
            </select>
        </div>
            @error('cateid')
    <div class="text-danger">{{ $message }}</div>
    @enderror

        <div class="col-6 mb-3">
            <label>Thương hiệu</label>
            <select name="brandid" class="form-control">
                <option selected disabled>-- Chọn thương hiệu --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">
                        {{ $brand->brandname }} 
                    </option>
                @endforeach
            </select>
        </div>
            @error('brandid')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    </div>

        {{-- ==== hiển thị checkbox Ẩn/hiện sản phẩm --}}
    <div class="mb-3">
        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
        <label class="form-check-label" for="status"> Hiển thị </label>
    </div>

    {{-- Ảnh thumbnail --}}
    <div class="mb-3 img-group">
        <label for="thumbnail">Hình ảnh đại diện</label>
        <input type="file" name="thumbnail" id="thumbnail" class="form-control img-input">
        {{-- Hiển thị ảnh preview --}}
        <div class="img-preview"></div>
        {{-- hiển thị lỗi cho field thumbnail --}}
        @error('thumbnail')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    {{-- Ảnh liên quan --}}
    <div class="mb-3 img-group">
        <label for="image">Hình ảnh</label>
        <input type="file" name="images[]" id="image" multiple class="form-control img-input">
        {{-- Hiển thị ảnh preview --}}
        <div class="img-preview"></div>
        {{-- hiển thị lỗi --}}
    @error('image')
        <p class="text-danger">{{ $message }}</p>
    @enderror
<!-- 
    @if($errors->has('images.*'))
        @foreach($errors->get('images.*') as $messages)
            @foreach($messages as $message)
                <p class="text-danger">{{ $message }}</p>
            @endforeach
        @endforeach
    @endif -->

    </div>

    <div class="mb-3">
        <label for="des">Mô tả cơ bản</label>
        <textarea name="des" id="des" class="form-control"></textarea>
    </div>

    <div class="d-flex m-2">
        <a href="{{ route('ad.product.index2') }}" class="btn btn-info">&LeftArrowBar;</a>
        <input type="submit" value="Lưu" class="btn btn-warning">
        <input type="reset" value="Làm lại" class="btn btn-primary">
    </div>

</form>

<!-- <script>
    const brandNameInput = document.getElementById('proname');
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