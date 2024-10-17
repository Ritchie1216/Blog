<style>
    /* 设置放大框的背景 */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none; /* 初始状态不显示 */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .overlay img {
        max-width: 90%; /* 放大后图片最大宽度 */
        max-height: 90%; /* 放大后图片最大高度 */
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.5); /* 为图片添加阴影效果 */
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    .custom-img-size {
        max-width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        cursor: pointer; /* 鼠标悬停时显示为可点击状态 */
    }
</style>

<script>
    // 点击图片时显示放大框
    function showImage(src) {
        document.getElementById('overlay-image').src = src;
        document.getElementById('overlay').style.display = 'flex';
    }

    // 关闭放大框
    function closeOverlay() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Blog Posts</h1>

        <!-- 显示成功消息 -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">{{ $post->title }}</h2>
                            <p class="card-text">{{ $post->content }}</p>

                            @foreach ($post->images as $image)
                                <img src="{{ asset($image->image) }}" class="img-fluid custom-img-size" alt="Post image" onclick="showImage('{{ asset($image->image) }}')">
                            @endforeach

                            <div class="mt-3">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 放大图片的 overlay -->
    <div id="overlay" class="overlay" onclick="closeOverlay()">
        <span class="close-btn">&times;</span>
        <img id="overlay-image" src="" alt="Expanded image">
    </div>
@endsection
