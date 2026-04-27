@extends('admin.layouts.app')
@section('title', 'Sản phẩm - Sửa')
@section('content')

<form action="{{ route('ad.product.update', $model->id) }}" method="post" class="m-auto w-auto border p-3" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h3>Sửa sản phẩm - <mark>{{ $model->proname }}</mark></h3>
    
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
        <input type="text" name="proname" id="proname" class="form-control" value="{{old('proname',$model->proname) }}">
    </div>
    {{-- Hiển thị lỗi cho field proname --}}
    @error('proname')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="slug">slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{old('slug',$model->slug)}}">
    </div>
    {{-- Hiển thị lỗi cho field slug --}}
    @error('slug')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="price">Giá</label>
        <input type="number" name="price" class="form-control w-50" value="{{ $model->price }}">
    </div>

    {{-- Dropdown loại sản phẩm, thương hiệu --}}
    <div class="row">
        <div class="col-6 mb-3">
            <label>Danh mục</label>
            <select name="cateid" class="form-control">
                <option selected disabled>-- Chọn danh mục --</option>
                @foreach($categories as $cate)
                    <option value="{{ $cate->cateid }}" 
                        {{ old('cateid',$model->cateid ?? '') == $cate->cateid ? 'selected' : '' }}>
                        {{ $cate->catename }}
                    </option>
                @endforeach
            </select>
        </div>
            {{-- Hiển thị lỗi --}}
    @error('cateid')
    <div class="text-danger">{{ $message }}</div>
    @enderror

        <div class="col-6 mb-3">
            <label>Thương hiệu</label>
            <select name="brandid" class="form-control" >
                <option selected disabled>-- Chọn thương hiệu --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" 
                        {{ old('brandid',$model->brandid ??'') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->brandname }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
        {{-- Hiển thị lỗi cho--}}
    @error('brandid')
    <div class="text-danger">{{ $message }}</div>
    @enderror

            {{-- ==== hiển thị checkbox Ẩn/hiện sản phẩm --}}
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" name="status" 
            id="status" {{ $model->status==1 ? 'checked' : '' }} >
        <label for="status" class="form-check-label">Hiển thị</label>
    </div>

    
    {{-- Ảnh thumbnail --}}
    <div class="mb-3 img-group">
        <label for="thumbnail">Hình ảnh đại diện</label>
        <input type="file" name="thumbnail" id="thumbnail" class="form-control img-input">
        {{-- Hiển thị ảnh preview --}}
        <div class="img-preview">
            <img src="{{ asset('storage/products/' . $model->thumbnail) }}"
            width="150" alt="{{ $model->thumbnail }}">
        </div>
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
        <div class="img-preview">
@foreach($model->images as $img)
    <div class="d-inline-block me-2 mb-2">
        <img src="{{ asset('storage/products/' . $img->image) }}" width="120">

        <div>
            <label>
                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                Xóa
            </label>
        </div>
    </div>
@endforeach
        </div>
        {{-- hiển thị lỗi --}}
        @error('image')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="des">Mô tả cơ bản</label>
        <textarea name="des" id="des" class="form-control">{{ $model->description }}</textarea>
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