<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- 导航栏 -->
    <nav class="main-nav">
        <div class="nav-container">
            <a class="nav-brand" href="{{ route('posts.index') }}">
                <i class="fas fa-blog"></i>
                <span>My Blog</span>
            </a>
            
            <button class="mobile-toggle" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="nav-menu">
                <a href="{{ route('posts.index') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.create') }}" class="nav-link">
                    <i class="fas fa-pen-fancy"></i>
                    <span>Create Post</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- 主体内容 -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- 底部 -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <i class="fas fa-blog"></i>
                <h3>My Blog</h3>
                <p>Share your stories with the world</p>
            </div>
            
            <div class="footer-links">
                <div class="link-group">
                    <h4>Quick Links</h4>
                    <a href="{{ route('posts.index') }}">Home</a>
                    <a href="{{ route('posts.create') }}">Create Post</a>
                </div>
                
                <div class="link-group">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        
                        <a href="https://www.facebook.com/profile.php?id=100009101916918" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/ritchie121600/" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} My Blog. All rights reserved.</p>
        </div>
    </footer>

    <style>
    /* 导航栏样式 */
    .main-nav {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .nav-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-brand {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .nav-brand:hover {
        color: #3182ce;
    }

    .nav-menu {
        display: flex;
        gap: 2rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #4a5568;
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        transform: translateY(-2px);
    }

    .mobile-toggle {
        display: none;
        flex-direction: column;
        gap: 6px;
        background: none;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
    }

    .mobile-toggle span {
        display: block;
        width: 25px;
        height: 2px;
        background: #4a5568;
        transition: all 0.3s ease;
    }

    /* 主体内容样式 */
    .main-content {
        min-height: calc(100vh - 200px);
        background: #f8fafc;
    }

    /* 底部样式 */
    .main-footer {
        background: #2d3748;
        color: white;
        padding: 4rem 2rem 1rem;
    }

    .footer-content {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 4rem;
        margin-bottom: 3rem;
    }

    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .footer-brand h3 {
        font-size: 1.5rem;
        margin: 0;
    }

    .footer-brand p {
        color: #a0aec0;
        margin: 0;
    }

    .footer-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
    }

    .link-group h4 {
        color: #e2e8f0;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .link-group a {
        display: block;
        color: #a0aec0;
        text-decoration: none;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .link-group a:hover {
        color: white;
        transform: translateX(5px);
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #3182ce;
        transform: translateY(-3px);
        color: white;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1.5rem;
        text-align: center;
        color: #a0aec0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .mobile-toggle {
            display: flex;
        }

        .nav-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-menu.active {
            display: flex;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-links {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .nav-container {
            padding: 1rem;
        }

        .nav-brand span {
            font-size: 1.25rem;
        }

        .main-footer {
            padding: 2rem 1rem 1rem;
        }
    }
    </style>

    <script>
    function toggleMobileMenu() {
        const menu = document.querySelector('.nav-menu');
        const toggle = document.querySelector('.mobile-toggle');
        menu.classList.toggle('active');
        
        // 添加汉堡按钮动画
        toggle.classList.toggle('active');
    }

    // 滚动时添加阴影效果
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.main-nav');
        if (window.scrollY > 0) {
            nav.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        } else {
            nav.style.boxShadow = 'none';
        }
    });
    </script>

    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
