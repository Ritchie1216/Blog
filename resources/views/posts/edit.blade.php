@extends('layouts.app')

@section('content')
<form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="title" class="form-label">标题</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">内容</label>
        <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
    </div>

    <!-- 显示当前图片 -->
    <div class="mb-3">
        <label class="form-label">当前图片</label>
        <div class="d-flex flex-wrap">
            @foreach ($post->images as $image)
                <div class="me-2 mb-2">
                    <img src="{{ asset($image->image) }}" class="img-fluid" style="max-width: 150px;" alt="Current image">
                </div>
            @endforeach
        </div>
    </div>

    <!-- 上传新图片 -->
    <div class="mb-3">
        <label for="image" class="form-label">更换图片</label>
        <input type="file" name="image[]" class="form-control" multiple>
        <small class="form-text text-muted">可以上传多张图片。</small>
    </div>

    <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection
