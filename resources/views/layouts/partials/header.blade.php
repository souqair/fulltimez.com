<style>
/* ============================================
   MODERN NAVBAR - COMPLETE REDESIGN
   ============================================ */

/* Global Font Family for All Text */
.desktop-header,
.desktop-header *,
.mobile-header,
.mobile-header *,
.mobile-nav-menu,
.mobile-nav-menu * {
    font-family: sans-serif;
}

/* Desktop Header - Modern Design */
.desktop-header {
    background: #ffffff;
    border-bottom: 1px solid #f0f0f0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    font-family: sans-serif;
}

.desktop-header.scrolled {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.desktop-header .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 60px;
    max-width: 100%;
}

.desktop-header .logo {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.desktop-header .logo a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #000;
    font-weight: 700;
    font-size: 20px;
    transition: all 0.3s ease;
    font-family: sans-serif;
}

.desktop-header .logo a:hover {
    transform: scale(1.05);
}

.desktop-header .logo img {
    max-height: 35px;
    width: auto;
    margin-right: 8px;
}

.desktop-header nav {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    justify-content: center;
}

.desktop-header nav a {
    text-decoration: none;
    color: #333;
    font-size: 15px;
    font-weight: 500;
    padding: 10px 18px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    font-family: sans-serif;
}

.desktop-header nav a::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 6px;
    height: 6px;
    background: #000;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.desktop-header nav a:hover {
    color: #000;
    background: #f8f8f8;
}

.desktop-header nav a:hover::after {
    transform: translateX(-50%) scaleX(1);
}

.desktop-header nav a.active {
    color: #000;
    background: #f0f0f0;
    font-weight: 600;
}

.desktop-header nav a.active::after {
    transform: translateX(-50%) scaleX(1);
}

.desktop-header .header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.desktop-header .header-actions a {
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-family: sans-serif;
}

.desktop-header .header-actions .login-link {
    color: #333;
    background: transparent;
}

.desktop-header .header-actions .login-link:hover {
    color: #000;
    background: #f8f8f8;
}

.desktop-header .header-actions .get-started-btn {
    background: #000;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.desktop-header .header-actions .get-started-btn:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.desktop-header .header-actions .dashboard-link {
    color: #22c55e;
    background: rgba(34, 197, 94, 0.1);
    font-weight: 600;
}

.desktop-header .header-actions .dashboard-link:hover {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.desktop-header .header-actions .logout-link {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

.desktop-header .header-actions .logout-link:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

/* Mobile Header - Modern Design */
.mobile-header {
    background: #ffffff;
    border-bottom: 1px solid #f0f0f0;
    position: sticky;
    top: 0;
    z-index: 10000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 12px 20px;
    font-family: sans-serif;
}

.mobile-header-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.mobile-logo {
    flex: 1;
}

.mobile-logo a {
    display: flex;
    align-items: center;
}

.mobile-logo img {
    max-height: 32px;
    width: auto;
}

.mobile-header-btn {
    background: #000;
    color: #fff;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    font-family: sans-serif;
    position: relative;
    z-index: 10001;
}

.mobile-header-btn:hover {
    background: #333;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.mobile-header-btn:active {
    transform: scale(0.95);
}

/* Mobile Menu Overlay */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10001;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* Mobile Navigation Menu */
.mobile-nav-menu {
    position: fixed;
    top: 0;
    right: 0;
    width: 320px;
    max-width: 85vw;
    height: 100vh;
    background: #ffffff;
    box-shadow: -4px 0 30px rgba(0, 0, 0, 0.15);
    z-index: 10002;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
    font-family: sans-serif;
}

.mobile-nav-menu.show {
    transform: translateX(0);
}

.mobile-nav-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: #ffffff;
    position: sticky;
    top: 0;
    z-index: 10;
    font-family: sans-serif;
}

.mobile-nav-menu-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    font-family: sans-serif;
}

.mobile-menu-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: #ffffff;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: sans-serif;
}

.mobile-menu-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.mobile-nav-menu-content {
    padding: 20px 0;
}

.mobile-nav-menu-content a {
    display: flex;
    align-items: center;
    padding: 16px 24px;
    color: #333;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    font-family: sans-serif;
}

.mobile-nav-menu-content a i {
    margin-right: 16px;
    width: 24px;
    font-size: 18px;
    color: #666;
    transition: all 0.3s ease;
}

.mobile-nav-menu-content a:hover,
.mobile-nav-menu-content a.active {
    background: #f8f8f8;
    color: #000;
    border-left-color: #000;
    padding-left: 28px;
}

.mobile-nav-menu-content a:hover i,
.mobile-nav-menu-content a.active i {
    color: #000;
}

.mobile-nav-menu-content hr {
    margin: 20px 24px;
    border: none;
    border-top: 1px solid #e5e7eb;
}

.mobile-auth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px 20px;
    margin: 8px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-family: sans-serif;
}

.mobile-auth-btn.login-btn {
    background: #000;
    color: #fff;
}

.mobile-auth-btn.login-btn:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.mobile-auth-btn.register-btn {
    background: #f0f0f0;
    color: #000;
}

.mobile-auth-btn.register-btn:hover {
    background: #e0e0e0;
}

.mobile-auth-btn.dashboard-btn {
    background: #22c55e;
    color: #fff;
}

.mobile-auth-btn.dashboard-btn:hover {
    background: #16a34a;
}

.mobile-auth-btn.logout-btn {
    background: #ef4444;
    color: #fff;
}

.mobile-auth-btn.logout-btn:hover {
    background: #dc2626;
}

/* Responsive Design */
@media (max-width: 1199px) {
    .desktop-header .header-container {
        padding: 18px 40px;
    }
    
    .desktop-header nav a {
        padding: 10px 14px;
        font-size: 14px;
    }
}

@media (max-width: 991px) {
    .desktop-header {
        display: none !important;
    }
}

@media (min-width: 992px) {
    .mobile-header,
    .mobile-menu-overlay,
    .mobile-nav-menu {
        display: none !important;
    }
}

/* Custom Scrollbar for Mobile Menu */
.mobile-nav-menu::-webkit-scrollbar {
    width: 6px;
}

.mobile-nav-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.mobile-nav-menu::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.mobile-nav-menu::-webkit-scrollbar-thumb:hover {
    background: #999;
}
</style>

<!-- Desktop Header -->
<header class="desktop-header d-none d-lg-block" id="desktopHeader">
    <div class="header-container">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez">
            </a>
        </div>
        <nav>
            <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">Browse Jobs</a>
            <a href="{{ route('candidates.index') }}" class="{{ request()->routeIs('candidates.*') ? 'active' : '' }}">Browse Resumes</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        </nav>
        <div class="header-actions">
            @auth
            <a href="{{ route('dashboard') }}" class="dashboard-link">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="logout-link">Logout</a>
            </form>
            @else
            <a href="{{ route('login') }}" class="login-link">Login</a>
            <a href="{{ route('choose.role') }}" class="get-started-btn">Get Started</a>
            @endauth
        </div>
    </div>
</header>

<!-- Mobile Header -->
<div class="mobile-header d-lg-none">
    <div class="mobile-header-inner">
        <div class="mobile-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez">
            </a>
        </div>
        <button class="mobile-header-btn" id="mobileMenuToggle" type="button" aria-label="Menu">
            <i class="fa-solid fa-bars"></i>
        </button>
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
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); closeMobileMenu();" class="mobile-auth-btn logout-btn">
            <i class="fa-solid fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="mobile-auth-btn login-btn">
            <i class="fa-solid fa-sign-in-alt"></i> Login
        </a>
        <a href="{{ route('choose.role') }}" class="mobile-auth-btn register-btn">
            <i class="fa-solid fa-user-plus"></i> Get Started
        </a>
        @endauth
    </div>
</div>

<script>
// Mobile Menu Toggle
function openMobileMenu() {
    const menu = document.getElementById('mobileNavMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    if (menu) menu.classList.add('show');
    if (overlay) overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    const menu = document.getElementById('mobileNavMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    if (menu) menu.classList.remove('show');
    if (overlay) overlay.classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const menuClose = document.getElementById('mobileMenuClose');
    const overlay = document.getElementById('mobileMenuOverlay');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', openMobileMenu);
    }
    
    if (menuClose) {
        menuClose.addEventListener('click', closeMobileMenu);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMobileMenu);
    }
    
    // Close menu on link click
    const menuLinks = document.querySelectorAll('.mobile-nav-menu-content a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(closeMobileMenu, 200);
        });
    });
    
    // Close menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            closeMobileMenu();
        }
    });
    
    // Desktop header scroll effect
    const desktopHeader = document.getElementById('desktopHeader');
    if (desktopHeader) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 50) {
                desktopHeader.classList.add('scrolled');
            } else {
                desktopHeader.classList.remove('scrolled');
            }
            lastScroll = currentScroll;
        });
    }
});
</script>
