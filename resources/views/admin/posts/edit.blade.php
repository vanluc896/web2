@extends('admin.layouts.app')
@section('title', 'Sửa bài viết')
@section('content')

<form action="{{ route('ad.posts.update', ['id' => $model->id]) }}" method="post" enctype="multipart/form-data" class="m-auto w-auto border p-3">
    @csrf
    @method('PUT')

    <h3>Sửa bài viết - <mark>{{ $model->title }}</mark></h3>
    @include('components.admin.panel-error')

    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $model->title) }}">
    </div>
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $model->slug) }}">
    </div>
    @error('slug')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>User</label>
        <select name="userid" class="form-control">
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('userid', $model->userid) == $u->id ? 'selected' : '' }}>
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
        <div class="mt-2">
            <img src="{{ asset('storage/posts/' . ($model->image ?: 'default.png')) }}" alt="{{ $model->title }}"
                width="140" class="img-thumbnail">
        </div>
    </div>
    @error('image')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Nội dung</label>
        <textarea name="content" class="form-control" rows="6">{{ old('content', $model->content) }}</textarea>
    </div>
    @error('content')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', (string) $model->status) == '1' ? 'selected' : '' }}>Hiện</option>
            <option value="0" {{ old('status', (string) $model->status) == '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>
    @error('status')
    <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="d-flex m-2">
        <a href="{{ route('ad.posts.index') }}" class="btn btn-info">&LeftArrowBar;</a>
        <input type="submit" value="Cập nhật" class="btn btn-warning">
        <input type="reset" value="Làm lại" class="btn btn-primary">
    </div>
</form>

@endsection
