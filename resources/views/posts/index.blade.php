@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="page-container">
    <div class="posts-header">
        <h1 class="main-title">All Posts</h1>
        <div class="header-decoration">
            <span class="decoration-dot"></span>
            <span class="decoration-dot"></span>
            <span class="decoration-dot"></span>
        </div>
    </div>
    
    <div class="posts-grid">
        @foreach ($posts as $post)
            <div class="post-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="post-content">
                    <div class="post-meta">
                        <span class="post-date">{{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->images->count() > 0)
                            <span class="post-images-count">
                                <i class="fas fa-images"></i> {{ $post->images->count() }}
                            </span>
                        @endif
                    </div>

                    <h2 class="post-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h2>
                    
                    <p class="post-excerpt">{{ Str::limit($post->content, 100) }}</p>
                    
                    @if($post->images->count() > 0)
                        <div class="post-images">
                            @foreach ($post->images->take(4) as $image)
                                <div class="image-wrapper">
                                    <img src="{{ asset($image->image) }}" 
                                         class="post-image" 
                                         alt="Post image" 
                                         onclick="showImage('{{ asset($image->image) }}')"
                                         loading="lazy">
                                </div>
                            @endforeach
                            @if($post->images->count() > 4)
                                <div class="image-wrapper more-images">
                                    <div class="more-overlay">
                                        <span>+{{ $post->images->count() - 4 }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="post-actions">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" 
                                    onclick="return confirm('Are you sure you want to delete this post?');">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="overlay" class="overlay">
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
    </div>

    <div id="deleteModal" class="delete-modal">
        <div class="modal-content" data-aos="zoom-in">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle warning-icon"></i>
                <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <p class="modal-subtitle">This action cannot be undone. All images associated with this post will also be deleted.</p>
            </div>
            <div class="modal-actions">
                <button class="modal-btn cancel-btn" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="modal-btn confirm-btn" onclick="executeDelete()">
                    <i class="fas fa-trash-alt"></i> Delete Post
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    background: #f8fafc;
}

.posts-header {
    text-align: center;
    margin-bottom: 3rem;
}

.main-title {
    color: #1a202c;
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.header-decoration {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.decoration-dot {
    width: 8px;
    height: 8px;
    background: #3182ce;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

.decoration-dot:nth-child(2) {
    animation-delay: 0.5s;
}

.decoration-dot:nth-child(3) {
    animation-delay: 1s;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.5; }
    100% { transform: scale(1); opacity: 1; }
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 2rem;
}

.post-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.post-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, #3182ce, #63b3ed);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
}

.post-card:hover::before {
    transform: scaleX(1);
}

.post-content {
    padding: 2rem;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #718096;
}

.post-images-count {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.post-title a {
    color: #2d3748;
    text-decoration: none;
    transition: color 0.3s ease;
    background: linear-gradient(to right, #3182ce, #3182ce);
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    padding-bottom: 2px;
}

.post-title a:hover {
    color: #3182ce;
    background-size: 100% 2px;
}

.post-excerpt {
    color: #4a5568;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.post-images {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.image-wrapper {
    position: relative;
    padding-top: 75%;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.image-wrapper:hover {
    transform: scale(1.05);
}

.post-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
}

.more-images {
    background: rgba(0, 0, 0, 0.1);
}

.more-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
    color: white;
    background: rgba(0, 0, 0, 0.5);
}

.post-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-view, .btn-edit, .btn-delete {
    padding: 0.7rem 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
    flex: 1;
    justify-content: center;
}

.btn-view {
    background-color: #3182ce;
    color: white;
}

.btn-view:hover {
    background-color: #2c5282;
    color: white;
}

.btn-edit {
    background-color: #ecc94b;
    color: #744210;
}

.btn-edit:hover {
    background-color: #d69e2e;
    color: white;
}

.btn-delete {
    background-color: #fc8181;
    color: #742a2a;
}

.btn-delete:hover {
    background-color: #f56565;
    color: white;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.95);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

#overlay-image {
    max-width: 90%;
    max-height: 90vh;
    border-radius: 8px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    animation: zoomIn 0.3s ease;
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

@keyframes zoomIn {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .posts-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }
}

@media (max-width: 768px) {
    .page-container {
        padding: 1rem;
    }

    .main-title {
        font-size: 2rem;
    }

    .posts-grid {
        grid-template-columns: 1fr;
    }

    .post-actions {
        flex-direction: column;
    }

    .nav-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .post-content {
        padding: 1.5rem;
    }

    .post-title {
        font-size: 1.3rem;
    }

    .post-images {
        grid-template-columns: repeat(2, 1fr);
    }
}

.delete-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 2000;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
    opacity: 0;
    transition: all 0.3s ease;
}

.delete-modal.active {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: white;
    border-radius: 15px;
    padding: 2.5rem;
    width: 90%;
    max-width: 450px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(-20px) scale(0.95);
    transition: all 0.3s ease;
}

.delete-modal.active .modal-content {
    transform: translateY(0) scale(1);
}

.modal-header {
    text-align: center;
    margin-bottom: 1.5rem;
    position: relative;
}

.warning-icon {
    font-size: 3.5rem;
    color: #f56565;
    margin-bottom: 1rem;
    display: inline-block;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-12deg); }
    75% { transform: rotate(12deg); }
}

.modal-header h3 {
    color: #2d3748;
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
}

.modal-body {
    text-align: center;
    margin-bottom: 2rem;
}

.modal-body p {
    color: #4a5568;
    margin: 0.5rem 0;
    line-height: 1.6;
}

.modal-subtitle {
    font-size: 0.9rem;
    color: #718096;
    margin-top: 0.75rem;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.modal-btn {
    padding: 0.875rem 1.75rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
    justify-content: center;
}

.cancel-btn {
    background: #edf2f7;
    color: #4a5568;
}

.cancel-btn:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

.confirm-btn {
    background: #f56565;
    color: white;
}

.confirm-btn:hover {
    background: #e53e3e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 101, 101, 0.2);
}

/* Responsive Design for Modal */
@media (max-width: 640px) {
    .modal-content {
        padding: 2rem;
        margin: 1rem;
    }

    .warning-icon {
        font-size: 3rem;
    }

    .modal-header h3 {
        font-size: 1.5rem;
    }

    .modal-actions {
        flex-direction: column;
    }

    .modal-btn {
        width: 100%;
    }

    .cancel-btn {
        order: 2;
    }
}
</style>

<script>
let currentImageIndex = 0;
let currentImages = [];

function showImage(src) {
    const overlay = document.getElementById('overlay');
    const overlayImage = document.getElementById('overlay-image');
    
    // 获取当前文章的所有图片
    const postCard = event.target.closest('.post-card');
    currentImages = Array.from(postCard.querySelectorAll('.post-image')).map(img => img.src);
    currentImageIndex = currentImages.indexOf(src);
    
    overlayImage.src = src;
    overlay.style.display = 'flex';
    
    requestAnimationFrame(() => {
        overlay.style.opacity = '1';
    });
}

function changeImage(direction) {
    currentImageIndex = (currentImageIndex + direction + currentImages.length) % currentImages.length;
    const overlayImage = document.getElementById('overlay-image');
    overlayImage.style.opacity = '0';
    
    setTimeout(() => {
        overlayImage.src = currentImages[currentImageIndex];
        overlayImage.style.opacity = '1';
    }, 200);
}

function closeOverlay() {
    const overlay = document.getElementById('overlay');
    const overlayImage = document.getElementById('overlay-image');
    
    overlayImage.style.opacity = '0';
    overlay.style.opacity = '0';
    
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 300);
}

// ESC 键关闭图片
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeOverlay();
    } else if (event.key === 'ArrowLeft') {
        changeImage(-1);
    } else if (event.key === 'ArrowRight') {
        changeImage(1);
    }
});

// 防止点击图片时触发 overlay 的点击事件
document.getElementById('overlay-image').addEventListener('click', function(event) {
    event.stopPropagation();
});

let currentDeleteForm = null;

function showDeleteConfirmation(event, form) {
    event.preventDefault();
    currentDeleteForm = form;
    const modal = document.getElementById('deleteModal');
    modal.classList.add('active');
    
    // 添加进入动画
    requestAnimationFrame(() => {
        modal.querySelector('.modal-content').style.transform = 'translateY(0) scale(1)';
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('active');
    currentDeleteForm = null;
}

function executeDelete() {
    if (currentDeleteForm) {
        currentDeleteForm.submit();
    }
    closeDeleteModal();
}

// 点击模态框背景关闭
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeDeleteModal();
    }
});

// ESC 键关闭模态框
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && document.getElementById('deleteModal').classList.contains('active')) {
        closeDeleteModal();
    }
});

// 更新删除按钮的点击事件
document.querySelectorAll('.btn-delete').forEach(button => {
    const form = button.closest('form');
    button.onclick = function(event) {
        showDeleteConfirmation(event, form);
        return false;
    };
});
</script>

<!-- 添加 AOS 动画库 -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
@endsection
