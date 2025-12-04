<style>
/* Header CSS from HTML Design - Complete */
header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    padding: 20px 60px; 
    background: #fff;
    width: 100%;
    box-sizing: border-box;
}

header .logo {
    font-weight: 700;
    font-size: 18px;
    color: #000;
}

header .logo a {
    color: #000;
    text-decoration: none;
    display: flex;
    align-items: center;
}

header .logo img {
    max-height: 30px;
    vertical-align: middle;
}

header nav {
    display: flex;
    align-items: center;
}

header nav a {
    text-decoration: none; 
    color: #000; 
    margin: 0 15px; 
    font-size: 14px;
    transition: color 0.3s ease;
}

header nav a:hover {
    color: #333;
}

header > div:last-child {
    display: flex;
    align-items: center;
    gap: 15px;
}

header > div:last-child a {
    text-decoration: none; 
    color: #000; 
    margin: 0 15px; 
    font-size: 14px;
    transition: color 0.3s ease;
}

header > div:last-child a:hover {
    color: #333;
}

.btn-small { 
    background: #000; 
    color: #fff; 
    padding: 6px 14px; 
    border-radius: 6px; 
    font-size: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.btn-small:hover {
    background: #333;
    color: #fff;
}

/* Responsive Header */
@media (max-width: 991px) {
    header {
        padding: 15px 20px;
    }
    
    header nav a,
    header > div:last-child a {
        margin: 0 10px;
        font-size: 13px;
    }
}

@media (max-width: 768px) {
    header {
        padding: 12px 15px;
    }
    
    header nav a,
    header > div:last-child a {
        margin: 0 8px;
        font-size: 12px;
    }
    
    .btn-small {
        padding: 5px 12px;
        font-size: 11px;
    }
}

/* Top Navigation Menu Styling - Simple */
.top-nav {
    padding: 8px 6px 10px; !implements
}

.top-nav .tabs {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}

.top-nav .tab {
    margin: 0;
    padding: 0;
}

.top-nav .tab a {
    display: inline-block;
    padding: 8px 10px;
    color: #4a5568;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.top-nav .tab a:hover {
    color: #007bff;
    background: #f0f4ff;
}

/* Active state */
.top-nav .tab a.active {
    color: #007bff;
    background: #f0f4ff;
}

/* Auth Buttons Styling - Simple */
.auth-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.auth-btn {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.auth-btn.login-btn {
    background: #007bff;
    color: #ffffff;
}

.auth-btn.login-btn:hover {
    background: #0056b3;
    color: #ffffff;
}

.auth-btn.register-btn {
    background: #ffffff;
    color: #007bff;
    border: 1px solid #007bff;
}

.auth-btn.register-btn:hover {
    background: #007bff;
    color: #ffffff;
}

.auth-btn.dashboard-btn {
    background: #22c55e;
    color: #ffffff;
}

.auth-btn.dashboard-btn:hover {
    background: #16a34a;
    color: #ffffff;
}

.auth-btn.logout-btn {
    background: #ffffff;
    color: #ef4444;
    border: 1px solid #ef4444;
}

.auth-btn.logout-btn:hover {
    background: #ef4444;
    color: #ffffff;
}

/* Mobile Navigation Toggle */
.mobile-nav-toggle {
    background: #007bff;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.mobile-nav-toggle:hover {
    background: #0056b3;
}

/* Mobile Only Styles - Works in Browser Responsive Mode Too */
@media (max-width: 991.98px) {
    /* Mobile Menu Overlay */
    .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        display: block !important;
    }

    .mobile-menu-overlay.show {
        opacity: 1;
        visibility: visible;
        display: block !important;
    }

    /* Mobile Navigation Drawer - Clean Implementation */
    .mobile-nav-menu {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        width: 320px !important;
        max-width: 85vw !important;
        height: 100vh !important;
        background: #ffffff !important;
        box-shadow: -4px 0 30px rgba(0, 0, 0, 0.2) !important;
        padding: 0 !important;
        z-index: 99999 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        transform: translateX(100%) !important;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
        will-change: transform;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .mobile-nav-menu.show {
        transform: translateX(0) !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* Custom Scrollbar for Mobile Menu */
    .mobile-nav-menu::-webkit-scrollbar {
        width: 6px;
    }
    
    .mobile-nav-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .mobile-nav-menu::-webkit-scrollbar-thumb {
        background: #007bff;
        border-radius: 3px;
    }
    
    .mobile-nav-menu::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }
}

@media (min-width: 992px) {
    .mobile-menu-overlay,
    .mobile-nav-menu {
        display: none !important;
        visibility: hidden !important;
    }
    
    .mobile-menu-overlay.show,
    .mobile-nav-menu.show {
        display: none !important;
    }
}

@media (max-width: 991.98px) {
    /* Mobile Menu Header */
    .mobile-nav-menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #ffffff;
        margin-bottom: 0;
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.2);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .mobile-nav-menu-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.5px;
    }

    .mobile-menu-close {
        background: rgba(255, 255, 255, 0.25);
        border: none;
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        padding: 10px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .mobile-menu-close:hover,
    .mobile-menu-close:active {
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(90deg) scale(1.1);
    }

    /* Mobile Menu Content */
    .mobile-nav-menu-content {
        padding: 24px 20px;
        background: #ffffff;
    }

    .mobile-nav-menu a {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        color: #1f2937;
        text-decoration: none;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: all 0.25s ease;
        font-weight: 600;
        font-size: 16px;
        border-left: 4px solid transparent;
        background: #f8fafc;
        position: relative;
        overflow: hidden;
    }
    
    .mobile-nav-menu a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #007bff;
        transform: scaleY(0);
        transition: transform 0.25s ease;
    }

    .mobile-nav-menu a i {
        margin-right: 16px;
        width: 24px;
        text-align: center;
        font-size: 20px;
        color: #6b7280;
        transition: all 0.25s ease;
    }

    .mobile-nav-menu a:hover,
    .mobile-nav-menu a.active {
        background: linear-gradient(90deg, #e3f2fd 0%, #f0f7ff 100%);
        color: #007bff;
        border-left-color: #007bff;
        transform: translateX(8px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }
    
    .mobile-nav-menu a:hover::before,
    .mobile-nav-menu a.active::before {
        transform: scaleY(1);
    }
    
    .mobile-nav-menu a:hover i,
    .mobile-nav-menu a.active i {
        color: #007bff;
        transform: scale(1.1);
    }

    .mobile-nav-menu hr {
        margin: 24px 0;
        border: none;
        border-top: 2px solid #e5e7eb;
        opacity: 0.6;
    }
}

@media (max-width: 991.98px) {
    .mobile-auth-btn {
        display: flex;
        align-items: center;
        padding: 16px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        margin-top: 10px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        justify-content: center;
    }

    .mobile-auth-btn i {
        margin-right: 14px;
        width: 22px;
        text-align: center;
        font-size: 18px;
    }
}

@media (max-width: 991.98px) {
    .mobile-auth-btn.login-btn {
        background: #007bff;
        color: #ffffff;
    }

    .mobile-auth-btn.login-btn:hover {
        background: #0056b3;
    }

    .mobile-auth-btn.register-btn {
        background: #ffffff;
        color: #007bff;
        border: 2px solid #007bff;
    }

    .mobile-auth-btn.register-btn:hover {
        background: #007bff;
        color: #ffffff;
    }

    .mobile-auth-btn.dashboard-btn {
        background: #22c55e;
        color: #ffffff;
    }

    .mobile-auth-btn.dashboard-btn:hover {
        background: #16a34a;
    }

    .mobile-auth-btn.logout-btn {
        background: #ffffff;
        color: #ef4444;
        border: 2px solid #ef4444;
    }

    .mobile-auth-btn.logout-btn:hover {
        background: #ef4444;
        color: #ffffff;
    }
}

@media (max-width: 991px) {
    .top-nav .tabs {
        gap: 8px;
    }
    
    .top-nav .tab a {
        padding: 6px 12px;
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    .auth-buttons {
        gap: 6px;
    }
    
    .auth-btn {
        padding: 6px 14px;
        font-size: 13px;
    }
}

/* Mobile Header - Completely Separate - Mobile Only */
@media (max-width: 991.98px) {
    .mobile-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 0;
        width: 100%;
        max-width: 100vw;
        margin: 0;
        left: 0;
        right: 0;
    }
    
    .mobile-header .container,
    .mobile-header .container-fluid {
        width: 100%;
        max-width: 100%;
        padding-left: 15px;
        padding-right: 15px;
        margin: 0;
    }
    
    .mobile-header .py-3 {
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }

    .mobile-header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        gap: 12px;
        max-width: 100%;
    }

    .mobile-logo {
        flex: 1 1 auto;
        display: flex;
        align-items: center;
        min-width: 0;
        overflow: hidden;
    }

    .mobile-logo a {
        display: flex;
        align-items: center;
        max-width: 100%;
    }

    .mobile-logo img {
        max-height: 40px;
        width: auto;
        height: auto;
        max-width: 100%;
        object-fit: contain;
    }

    .mobile-header-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }

    .mobile-header-btn {
        background: #007bff;
        color: #ffffff;
        border: none;
        padding: 0;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        width: 44px;
        height: 44px;
        position: relative;
        z-index: 1001;
        pointer-events: auto;
        -webkit-tap-highlight-color: transparent;
        box-shadow: 0 2px 6px rgba(0, 123, 255, 0.2);
        flex-shrink: 0;
    }
    
    .mobile-header-btn i {
        font-size: 18px;
    }
    
    .mobile-header-btn:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    .mobile-header-btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 3px rgba(0, 123, 255, 0.2);
    }
}

@media (min-width: 992px) {
    .mobile-header {
        display: none !important;
    }
}

/* Desktop Header - Completely Separate */
.desktop-header {
    background: #ffffff;
}

/* Login/Register Links Styling */
.login {
    display: inline-block;
}

.login a {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.login:first-child a {
    background: #007bff;
    color: #ffffff;
}

.login:first-child a:hover {
    background: #0056b3;
    color: #ffffff;
}

.login:last-child a {
    background: #ffffff;
    color: #007bff;
    border: 1px solid #007bff;
}

.login:last-child a:hover {
    background: #007bff;
    color: #ffffff;
}

/* Mobile Search Toggle - Beautiful Design */
@media (max-width: 991.98px) {
    .search-wrap {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        z-index: 10000;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        transform: translateY(-100%);
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: block !important;
        padding: 0 !important;
        max-height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .search-wrap.show {
        transform: translateY(0) !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: block !important;
    }
    
    /* Search Box Close Button - Beautiful Design */
    .mobile-search-close {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #ffffff;
        font-size: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-search-close:hover,
    .mobile-search-close:active {
        background: rgba(255, 255, 255, 0.5);
        transform: rotate(90deg) scale(1.05);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Search Box Header - Beautiful Gradient */
    .mobile-search-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 16px 18px 16px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #004085 100%);
        color: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 123, 255, 0.3);
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 3px solid rgba(255, 255, 255, 0.1);
    }
    
    .mobile-search-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        pointer-events: none;
    }
    
    .mobile-search-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .mobile-search-header h3 i {
        font-size: 20px;
        margin-right: 8px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }
    
    /* Search form padding for mobile - Beautiful spacing */
    .search-wrap form {
        padding: 20px 16px 24px 16px;
        background: transparent;
    }
    
    /* Search form fields styling */
    .search-wrap .search-barwrp {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }
    
    .search-wrap .field {
        margin-bottom: 20px;
    }
    
    .search-wrap .field:last-child {
        margin-bottom: 0;
    }
    
    .search-wrap .label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 14px;
        letter-spacing: 0.3px;
    }
    
    .search-wrap .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #ffffff;
        color: #1f2937;
    }
    
    .search-wrap .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .search-wrap .btn.primary {
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        margin-top: 10px;
    }
    
    .search-wrap .btn.primary:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    }
    
    .search-wrap .btn.primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }
}

@media (min-width: 992px) {
    .search-wrap {
        display: block !important;
        opacity: 1;
        visibility: visible;
    }
}
</style>

<!-- Desktop Header - Only shows on desktop -->
<header class="desktop-header d-none d-lg-block">
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez">
        </a>
    </div>
    <nav>
        <a href="{{ route('jobs.index') }}">Browse Jobs</a>
        <a href="{{ route('candidates.index') }}">Browse Resumes</a>
        <a href="{{ route('contact') }}">Contact Us</a>
    </nav>
    <div>
        @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
        </form>
        @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('choose.role') }}" class="btn-small">Get Started</a>
        @endauth
    </div>
</header>

<!-- Mobile Header - Only shows on mobile -->
<div class="mobile-header d-lg-none">
    <div class="container-fluid py-3" style="padding-left: 15px; padding-right: 15px;">
        <div class="mobile-header-inner">
            <div class="mobile-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez Logo">
                </a>
            </div>
            <div class="mobile-header-buttons">
                <button class="mobile-header-btn" id="mobileMenuToggle" type="button" aria-label="Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- Mobile Navigation Menu -->
<div class="mobile-nav-menu" id="mobileNavMenu">
    <div class="mobile-nav-menu-header">
        <h3>Menu</h3>
        <button class="mobile-menu-close" id="mobileMenuClose" type="button" aria-label="Close Menu">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    <div class="mobile-nav-menu-content">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-home"></i> Home
        </a>
        <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-briefcase"></i> Browse Jobs
        </a>
        <a href="{{ route('candidates.index') }}" class="{{ request()->routeIs('candidates.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Browse Resumes
        </a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
            <i class="fa-solid fa-envelope"></i> Contact Us
        </a>
        <hr>
        @auth
        <a href="{{ route('dashboard') }}" class="mobile-auth-btn dashboard-btn">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mobile-auth-btn logout-btn">
            <i class="fa-solid fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="mobile-auth-btn login-btn">
            <i class="fa-solid fa-sign-in-alt"></i> LOGIN
        </a>
        <a href="{{ route('choose.role') }}" class="mobile-auth-btn register-btn">
            <i class="fa-solid fa-user-plus"></i> REGISTER
        </a>
        @endauth
    </div>
    </div>
</div>

</div>

