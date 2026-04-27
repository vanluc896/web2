@extends('admin.layouts.app')
@section('title', 'Loại sản phẩm')
@section('content')

<h3>Sửa loại sản phẩm - <mark>{{ $model->brandname }}</mark></h3>
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

<form action="{{ route('ad.brands.update', $model->id) }}" method="post" class="w-75" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="brandname">Tên loại</label>
    <input type="text" name="brandname" id="brandname" class="form-control" value="{{old('brandname', $model->brandname) }}">
        {{-- Hiển thị lỗi cho brandname --}}
    @error('brandname')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <label for="slug">slug</label>
    <input type="text" name="slug" id="slug" class="form-control" value="{{old('slug',$model->slug) }}">
               {{-- Hiển thị lỗi cho field slug --}}
    @error('slug')
    <div class="text-danger">{{ $message }}</div>
    @enderror

        {{-- ---------- --}}
    <div class="mb-3 img-group">
        <label for="thumbnail">Hình ảnh</label>
        <input type="file" name="thumbnail" id="thumbnail" class="form-control img-input">
        {{-- -hiển thị ảnh preview --}}
        <div class="img-preview">
            <img src="{{ asset('storage/brands/' . $model->thumbnail) }}"
            width="150" alt="{{ $model->thumbnail }}">
        </div>
               {{-- Hiển thị lỗi cho field thumbnail --}}
            @error('thumbnail')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" name="status" 
            id="status" {{ $model->status==1 ? 'checked' : '' }} >
        <label for="status" class="form-check-label">Hiển thị</label>
    </div>

    <label for="des">Mô tả cơ bản</label>
    <textarea name="des" id="des" class="form-control">{{ $model->description }}</textarea>

    <div class="d-flex m-2">
        <a href="{{ route('ad.brands.index') }}" class="btn btn-info">&LeftArrowBar;</a>

        <input type="submit" value="Lưu" class="btn btn-warning">
        <input type="reset" value="Làm lại" class="btn btn-primary">
    </div>
</form>


<!-- <script>
    const brandNameInput = document.getElementById('brandname');
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