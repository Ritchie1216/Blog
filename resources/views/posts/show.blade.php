@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>

        <div class="row">
            @foreach ($post->images as $image)
                <div class="col-md-6 mb-4">
                    <img src="{{ asset($image->image) }}" class="img-fluid custom-img-size" alt="Post image">
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
        </div>
    </div>
@endsection
