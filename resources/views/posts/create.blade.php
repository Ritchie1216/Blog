@extends('layouts.app')

@section('content')
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">标题</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">内容</label>
        <textarea name="content" id="content" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">上传图片</label>
        <input type="file" name="image[]" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-primary">提交</button>
</form>

@endsection
