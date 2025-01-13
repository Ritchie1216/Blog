@extends('layouts.app')

@section('content')
<div class="create-post-container">
    <div class="form-header">
        <h1>Create New Post</h1>
        <div class="header-line"></div>
    </div>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="post-form">
        @csrf
        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control" 
                   required
                   placeholder="Enter your post title">
        </div>

        <div class="form-group">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" 
                      id="content" 
                      class="form-control" 
                      required
                      placeholder="Write your post content here..."
                      rows="6"></textarea>
        </div>

        <div class="form-group">
            <label for="images" class="form-label">
                <i class="fas fa-images"></i> Upload Images
            </label>
            <div class="upload-area" id="uploadArea">
                <input type="file" 
                       name="image[]" 
                       id="images" 
                       class="file-input" 
                       multiple
                       accept="image/*"
                       onchange="handleFileSelect(this)">
                <div class="upload-message">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Drag and drop images here or click to select</p>
                    <span class="file-info">Supports: JPG, PNG, GIF (Max: 5MB)</span>
                </div>
            </div>
            <div id="imagePreview" class="image-preview-container"></div>
        </div>

        <div class="form-actions">
            <a href="{{ route('posts.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Publish Post
            </button>
        </div>
    </form>
</div>

<style>
.create-post-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-header h1 {
    color: #2d3748;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.header-line {
    height: 4px;
    width: 100px;
    background: linear-gradient(to right, #3182ce, #63b3ed);
    margin: 0 auto;
    border-radius: 2px;
}

.post-form {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.upload-area {
    position: relative;
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    border-color: #3182ce;
    background: rgba(49, 130, 206, 0.02);
}

.upload-area.dragover {
    border-color: #3182ce;
    background: rgba(49, 130, 206, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-message {
    color: #4a5568;
}

.upload-message i {
    font-size: 2rem;
    color: #3182ce;
    margin-bottom: 1rem;
}

.file-info {
    display: block;
    font-size: 0.875rem;
    color: #718096;
    margin-top: 0.5rem;
}

.image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.image-preview {
    position: relative;
    padding-top: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.image-preview img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-image:hover {
    background: rgba(0, 0, 0, 0.7);
    transform: scale(1.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: #3182ce;
    color: white;
    flex: 1;
    justify-content: center;
}

.btn-primary:hover {
    background: #2c5282;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-secondary:hover {
    background: #cbd5e0;
    color: #2d3748;
}

/* Responsive Design */
@media (max-width: 768px) {
    .create-post-container {
        margin: 1rem auto;
    }

    .form-header h1 {
        font-size: 2rem;
    }

    .post-form {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .form-header h1 {
        font-size: 1.75rem;
    }

    .post-form {
        padding: 1rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-secondary {
        order: 2;
    }
}
</style>

<script>
function handleFileSelect(input) {
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'image-preview';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function() {
                        previewWrapper.remove();
                        // Note: You'll need additional logic to actually remove the file from the input
                    };
                    
                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(removeBtn);
                    previewContainer.appendChild(previewWrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// 拖放功能
const uploadArea = document.getElementById('uploadArea');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.classList.add('dragover');
}

function unhighlight(e) {
    uploadArea.classList.remove('dragover');
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const fileInput = document.getElementById('images');
    
    // 创建一个新的 FileList 对象
    const dataTransfer = new DataTransfer();
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            dataTransfer.items.add(file);
        }
    });
    
    fileInput.files = dataTransfer.files;
    handleFileSelect(fileInput);
}
</script>
@endsection
