<!-- resources/views/posts/show.blade.php -->
@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="post-container">
    <div class="post-header" data-aos="fade-down">
        <h1 class="post-title">{{ $post->title }}</h1>
        <div class="post-meta">
            <span class="post-date">
                <i class="fas fa-calendar-alt"></i>
                {{ $post->created_at->format('M d, Y') }}
            </span>
            @if($post->images->count() > 0)
                <span class="post-images-count">
                    <i class="fas fa-images"></i>
                    {{ $post->images->count() }} Images
                </span>
            @endif
        </div>
    </div>

    <div class="post-content" data-aos="fade-up">
        <div class="content-text">
            {{ $post->content }}
        </div>

        @if($post->images->count() > 0)
            <div class="images-section">
                <h3 class="images-title">Gallery</h3>
                <div class="image-grid">
                    @foreach ($post->images as $image)
                        <div class="image-card" data-aos="fade-up">
                            <div class="image-wrapper">
                                <img src="{{ asset($image->image) }}" 
                                     alt="Post image" 
                                     onclick="showImage('{{ asset($image->image) }}')"
                                     loading="lazy">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="post-actions" data-aos="fade-up">
        <a href="{{ route('posts.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Posts</span>
        </a>
    </div>
</div>

<!-- 图片查看器 -->
<div id="overlay" class="overlay" onclick="closeOverlay()">
    <button class="close-btn" onclick="closeOverlay()">
        <i class="fas fa-times"></i>
    </button>
    <button class="nav-btn prev-btn" onclick="changeImage(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <img id="overlay-image" src="" alt="Expanded image">
    <button class="nav-btn next-btn" onclick="changeImage(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="image-counter">
        <span id="current-image">1</span> / <span id="total-images">1</span>
    </div>
</div>

<style>
.post-container {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 1.5rem;
}

.post-header {
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
}

.post-title {
    font-size: 3rem;
    color: #2d3748;
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.2;
    background: linear-gradient(to right, #2c5282, #3182ce);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.post-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    color: #718096;
    font-size: 1.1rem;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #4a5568;
    margin-bottom: 2.5rem;
}

.images-section {
    border-top: 2px solid #e2e8f0;
    padding-top: 2rem;
}

.images-title {
    color: #2d3748;
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}

.image-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.image-card:hover {
    transform: translateY(-5px);
}

.image-wrapper {
    position: relative;
    padding-top: 75%;
    overflow: hidden;
    border-radius: 12px;
}

.image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.image-wrapper:hover img {
    transform: scale(1.05);
}

.post-actions {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: #3182ce;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);
}

.btn-back:hover {
    background: #2c5282;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(49, 130, 206, 0.3);
    color: white;
}

/* 图片查看器样式 */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.overlay.active {
    opacity: 1;
}

#overlay-image {
    max-width: 90%;
    max-height: 90vh;
    border-radius: 8px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    transform: scale(0.95);
    transition: transform 0.3s ease;
}

.overlay.active #overlay-image {
    transform: scale(1);
}

.close-btn, .nav-btn {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-btn {
    top: 20px;
    right: 20px;
}

.nav-btn {
    top: 50%;
    transform: translateY(-50%);
}

.prev-btn {
    left: 20px;
}

.next-btn {
    right: 20px;
}

.close-btn:hover, .nav-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.nav-btn:hover {
    transform: translateY(-50%) scale(1.1);
}

.image-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 1.1rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .post-title {
        font-size: 2.5rem;
    }

    .post-content {
        padding: 2rem;
    }

    .image-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (max-width: 768px) {
    .post-container {
        margin: 2rem auto;
    }

    .post-title {
        font-size: 2rem;
    }

    .post-meta {
        flex-direction: column;
        gap: 1rem;
    }

    .content-text {
        font-size: 1rem;
    }

    .nav-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .post-container {
        padding: 0 1rem;
    }

    .post-title {
        font-size: 1.75rem;
    }

    .post-content {
        padding: 1.5rem;
    }

    .image-grid {
        grid-template-columns: 1fr;
    }

    .btn-back {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
let currentImageIndex = 0;
let images = [];

function showImage(src) {
    const overlay = document.getElementById('overlay');
    const overlayImage = document.getElementById('overlay-image');
    
    // 获取所有图片
    images = Array.from(document.querySelectorAll('.image-wrapper img')).map(img => img.src);
    currentImageIndex = images.indexOf(src);
    
    overlayImage.src = src;
    overlay.style.display = 'flex';
    
    // 更新计数器
    updateImageCounter();
    
    requestAnimationFrame(() => {
        overlay.classList.add('active');
    });
}

function changeImage(direction) {
    currentImageIndex = (currentImageIndex + direction + images.length) % images.length;
    const overlayImage = document.getElementById('overlay-image');
    
    overlayImage.style.opacity = '0';
    overlayImage.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        overlayImage.src = images[currentImageIndex];
        overlayImage.style.opacity = '1';
        overlayImage.style.transform = 'scale(1)';
        updateImageCounter();
    }, 200);
}

function updateImageCounter() {
    document.getElementById('current-image').textContent = currentImageIndex + 1;
    document.getElementById('total-images').textContent = images.length;
}

function closeOverlay() {
    const overlay = document.getElementById('overlay');
    overlay.classList.remove('active');
    
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 300);
}

// 键盘控制
document.addEventListener('keydown', function(event) {
    if (document.getElementById('overlay').style.display === 'flex') {
        if (event.key === 'Escape') {
            closeOverlay();
        } else if (event.key === 'ArrowLeft') {
            changeImage(-1);
        } else if (event.key === 'ArrowRight') {
            changeImage(1);
        }
    }
});

// 防止点击图片时触发 overlay 的点击事件
document.getElementById('overlay-image').addEventListener('click', function(event) {
    event.stopPropagation();
});
</script>
@endsection
