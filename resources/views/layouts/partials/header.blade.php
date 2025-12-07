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
    background: rgba(250, 250, 250, 0.7);
    border-bottom: none;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    font-family: sans-serif;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.desktop-header.scrolled {
    background: rgba(250, 250, 250, 0.85);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.desktop-header .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 60px;
    max-width: 100%;
    min-height: 60px;
}

.desktop-header .logo {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    height: 32px;
}

.desktop-header .logo a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #000;
    font-weight: 700;
    font-size: 22px;
    transition: all 0.3s ease;
    font-family: sans-serif;
    letter-spacing: -0.5px;
    line-height: 1;
    height: 32px;
}

.desktop-header .logo a:hover {
    transform: none;
}

.desktop-header .logo-text {
    font-weight: 700;
    color: #000;
    display: inline-block;
    line-height: 1;
    vertical-align: middle;
}

.desktop-header .logo-text .logo-full {
    font-weight: 500;
}

.desktop-header .logo-text .logo-timez {
    font-weight: 700;
}

.desktop-header nav {
    display: flex;
    align-items: center;
    gap: 32px;
    flex: 1;
    justify-content: flex-start;
    margin-left: 40px;
    height: 32px;
}

.desktop-header nav a {
    text-decoration: none;
    color: #6b7280;
    font-size: 15px;
    font-weight: 400;
    padding: 0;
    border-radius: 0;
    transition: all 0.3s ease;
    position: relative;
    font-family: sans-serif;
    line-height: 1;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    height: 32px;
}

.desktop-header nav a::after {
    display: none;
}

.desktop-header nav a:hover {
    color: #1a1a1a;
    background: transparent;
}

.desktop-header nav a.active {
    color: #1a1a1a;
    background: transparent;
    font-weight: 500;
}

.desktop-header .header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-shrink: 0;
    height: 32px;
}

.desktop-header .header-actions a {
    text-decoration: none;
    font-size: 15px;
    font-weight: 400;
    padding: 0;
    border-radius: 0;
    transition: all 0.3s ease;
    font-family: sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
    line-height: 1;
    white-space: nowrap;
    height: 32px;
}

.desktop-header .header-actions .login-link {
    color: #1a1a1a;
    background: transparent;
}

.desktop-header .header-actions .login-link:hover {
    color: #1a1a1a;
    background: transparent;
}

.desktop-header .header-actions .login-link .login-icon {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    flex-shrink: 0;
}

.desktop-header .header-actions .get-started-btn {
    background: #1a1a1a;
    color: #fff;
    font-weight: 500;
    padding: 10px 16px;
    border-radius: 12px;
    box-shadow: none;
    font-size: 14px;
    line-height: 1;
    height: auto;
    display: inline-flex;
    align-items: center;
}

.desktop-header .header-actions .get-started-btn:hover {
    background: #2d2d2d;
    transform: none;
    box-shadow: none;
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

.mobile-logo .logo-text {
    font-weight: 700;
    color: #000;
    font-size: 20px;
    letter-spacing: -0.5px;
    line-height: 1;
}

.mobile-logo .logo-text .logo-full {
    font-weight: 500;
}

.mobile-logo .logo-text .logo-timez {
    font-weight: 700;
}

.mobile-header-btn {
    background: #000;
    color: #fff;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex !important;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    font-family: sans-serif;
    position: relative;
    z-index: 10001;
    flex-shrink: 0;
}

/* Ensure icon is visible */
.mobile-header-btn i {
    display: inline-block !important;
    color: #fff !important;
    font-size: 18px !important;
    width: auto;
    height: auto;
    line-height: 1;
}

.mobile-header-btn .menu-icon-fallback {
    display: inline-block !important;
    color: #fff !important;
    font-size: 20px !important;
    line-height: 1;
    font-weight: bold;
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
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;
    width: 320px !important;
    max-width: 85vw !important;
    height: 100% !important;
    min-height: 100vh !important;
    background: #ffffff !important;
    box-shadow: -4px 0 30px rgba(0, 0, 0, 0.15) !important;
    z-index: 10002 !important;
    transform: translateX(100%) !important;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    overflow-y: auto !important;
    font-family: sans-serif !important;
    visibility: visible !important;
    opacity: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}

.mobile-nav-menu.show {
    transform: translateX(0) !important;
    visibility: visible !important;
    opacity: 1 !important;
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
        padding: 14px 40px;
        min-height: 60px;
    }
    
    .desktop-header nav {
        gap: 24px;
        margin-left: 30px;
    }
    
    .desktop-header nav a {
        font-size: 14px;
    }
    
    .desktop-header .header-actions {
        gap: 16px;
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
                <span class="logo-text">
                    <span class="logo-full">Full</span><span class="logo-timez">Timez</span>
                </span>
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
            <a href="{{ route('login') }}" class="login-link">
                <svg class="login-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Login
            </a>
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
                <span class="logo-text">
                    <span class="logo-full">Full</span><span class="logo-timez">Timez</span>
                </span>
            </a>
        </div>
        <button class="mobile-header-btn" id="mobileMenuToggle" type="button" aria-label="Menu">
            <span class="menu-icon-fallback" style="font-size: 20px; font-weight: bold; line-height: 1;">☰</span>
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
            <span style="font-size: 24px; font-weight: bold; line-height: 1;">✕</span>
        </button>
    </div>
    <div class="mobile-nav-menu-content">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <span style="margin-right: 10px; font-size: 18px;">🏠</span> Home
        </a>
        <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">
            <span style="margin-right: 10px; font-size: 18px;">💼</span> Browse Jobs
        </a>
        <a href="{{ route('candidates.index') }}" class="{{ request()->routeIs('candidates.*') ? 'active' : '' }}">
            <span style="margin-right: 10px; font-size: 18px;">👥</span> Browse Resumes
        </a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
            <span style="margin-right: 10px; font-size: 18px;">✉️</span> Contact Us
        </a>
        <hr>
        @auth
        <a href="{{ route('dashboard') }}" class="mobile-auth-btn dashboard-btn">
            <span style="margin-right: 10px; font-size: 18px;">📊</span> Dashboard
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); closeMobileMenu();" class="mobile-auth-btn logout-btn">
            <span style="margin-right: 10px; font-size: 18px;">🚪</span> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="mobile-auth-btn login-btn">
            <span style="margin-right: 10px; font-size: 18px;">🔑</span> Login
        </a>
        <a href="{{ route('choose.role') }}" class="mobile-auth-btn register-btn">
            <span style="margin-right: 10px; font-size: 18px;">➕</span> Get Started
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
    const menu = document.getElementById('mobileNavMenu');
    
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle clicked');
            openMobileMenu();
        });
    } else {
        console.error('Menu toggle button not found!');
    }
    
    if (menuClose) {
        menuClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });
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
