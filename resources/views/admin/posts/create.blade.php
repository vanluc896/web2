@extends('admin.layouts.app')
@section('title', 'Thêm bài viết')
@section('content')

<form action="{{ route('ad.posts.store') }}" method="post" enctype="multipart/form-data" class="m-auto w-auto border p-3">
    @csrf

    <h3>Thêm bài viết</h3>
    @include('components.admin.panel-error')

    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
    </div>
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
    </div>
    @error('slug')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>User</label>
        <select name="userid" class="form-control" required>
            <option value="" {{ old('userid') ? '' : 'selected' }}>-- Chọn user --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('userid') == $u->id ? 'selected' : '' }}>
                    {{ $u->fullname }} ({{ $u->username }})
                </option>
            @endforeach
        </select>
    </div>
    @error('userid')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Ảnh</label>
        <input type="file" name="image" class="form-control">
    </div>
    @error('image')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Nội dung</label>
        <textarea name="content" class="form-control" rows="6">{{ old('content') }}</textarea>
    </div>
    @error('content')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', '1') == 1 ? 'selected' : '' }}>Hiện</option>
            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>
    @error('status')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="d-flex m-2">
        <a href="{{ route('ad.posts.index') }}" class="btn btn-info">&LeftArrowBar;</a>
        <input type="submit" value="Lưu" class="btn btn-warning">
        <input type="reset" value="Làm lại" class="btn btn-primary">
    </div>
</form>

@endsection
