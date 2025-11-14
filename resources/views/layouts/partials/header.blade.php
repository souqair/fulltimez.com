<style>
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
        background: rgba(0, 0, 0, 0.6);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        display: block;
    }

    .mobile-menu-overlay.show {
        opacity: 1;
        visibility: visible;
        display: block;
    }

    .mobile-nav-menu {
        position: fixed;
        top: 0;
        right: -320px;
        width: 300px;
        max-width: 85%;
        height: 100vh;
        background: #ffffff;
        box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
        padding: 0;
        z-index: 9999;
        overflow-y: auto;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        visibility: visible;
    }

    .mobile-nav-menu.show {
        right: 0 !important;
        display: block !important;
        visibility: visible !important;
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
    .mobile-nav-menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #007bff;
        color: #ffffff;
        margin-bottom: 0;
    }

    .mobile-nav-menu-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
    }

    .mobile-menu-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        font-size: 20px;
        color: #ffffff;
        cursor: pointer;
        padding: 8px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .mobile-menu-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .mobile-nav-menu-content {
        padding: 20px;
    }

    .mobile-nav-menu a {
        display: flex;
        align-items: center;
        padding: 16px 18px;
        color: #374151;
        text-decoration: none;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 16px;
        border-left: 4px solid transparent;
        background: #f9fafb;
    }

    .mobile-nav-menu a i {
        margin-right: 14px;
        width: 22px;
        text-align: center;
        font-size: 18px;
    }

    .mobile-nav-menu a:hover,
    .mobile-nav-menu a.active {
        background: #e3f2fd;
        color: #007bff;
        border-left-color: #007bff;
        transform: translateX(5px);
    }

    .mobile-nav-menu hr {
        margin: 20px 0;
        border: none;
        border-top: 2px solid #e5e7eb;
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

/* Mobile Header - Completely Separate */
.mobile-header {
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    padding: 12px 0;
}

.mobile-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    gap: 15px;
}

.mobile-logo {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
}

.mobile-logo a {
    display: flex;
    align-items: center;
}

.mobile-logo img {
    max-height: 45px;
    width: auto;
    height: auto;
}

.mobile-header-buttons {
    display: flex;
    gap: 10px;
    align-items: center;
}

.mobile-header-btn {
    background: #007bff;
    color: #ffffff;
    border: none;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    position: relative;
    z-index: 1001;
    pointer-events: auto;
    -webkit-tap-highlight-color: transparent;
    height: 44px;
    box-shadow: 0 2px 6px rgba(0, 123, 255, 0.2);
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

/* Mobile Search Toggle - Works in Browser Responsive Mode */
@media (max-width: 991.98px) {
    .search-wrap {
        display: none !important;
        opacity: 0;
        visibility: hidden;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .search-wrap.show {
        display: block !important;
        opacity: 1;
        visibility: visible;
        max-height: 500px;
        padding: 20px 0 !important;
        margin-top: 15px !important;
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
<div class="desktop-header d-none d-lg-block">
    <div class="container py-3">
        <div class="app">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-3">
                    <div class="fulltimez-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez Logo">
                        </a>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="col-lg-6">
                    <nav class="top-nav">
                        <ul class="tabs">
                            <li class="tab"><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                            <li class="tab"><a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">Browse Jobs</a></li>
                            <li class="tab"><a href="{{ route('candidates.index') }}" class="{{ request()->routeIs('candidates.*') ? 'active' : '' }}">Browse Resumes</a></li>
                            <li class="tab"><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>

                <!-- Desktop Auth Links -->
                <div class="col-lg-3">
                    <div class="d-flex gap-2 justify-content-end">
                        <div class="auth-buttons">
                            @auth
                            <a href="{{ route('dashboard') }}" class="auth-btn dashboard-btn">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="auth-btn logout-btn">Logout</a>
                            </form>
                            @else
                            <div class="login"><a href="{{ route('login') }}">Login</a></div>
                            <div class="login"><a href="{{ route('choose.role') }}">Register</a></div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Header - Only shows on mobile -->
<div class="mobile-header d-lg-none">
    <div class="container py-3">
        <div class="mobile-header-inner">
            <div class="mobile-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/full-timez-logo.png') }}" alt="FullTimez Logo">
                </a>
            </div>
            <div class="mobile-header-buttons">
                <button class="mobile-header-btn" id="mobileSearchToggle" type="button" aria-label="Search" onclick="event.preventDefault(); event.stopPropagation(); console.log('Search clicked inline'); if(typeof toggleMobileSearch === 'function') toggleMobileSearch(); else { const sw = document.getElementById('searchWrapSection') || document.querySelector('.search-wrap'); if(sw) { sw.classList.toggle('show'); sw.style.display = sw.classList.contains('show') ? 'block' : 'none'; } } return false;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button class="mobile-header-btn" id="mobileMenuToggle" type="button" aria-label="Menu" onclick="event.preventDefault(); event.stopPropagation(); console.log('Menu clicked inline'); if(typeof openMobileMenu === 'function') openMobileMenu(); else { const menu = document.getElementById('mobileNavMenu'); const overlay = document.getElementById('mobileMenuOverlay'); if(menu && overlay) { menu.classList.add('show'); overlay.classList.add('show'); document.body.style.overflow = 'hidden'; } } return false;">
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

<!-- HR Separator - Only for Desktop -->
<hr class="mt-4 d-none d-lg-block">

    @if(!(auth()->check() && auth()->user()->isEmployer() && request()->routeIs('dashboard')) && !request()->routeIs('candidates.index') && !request()->routeIs('jobs.index') && !request()->routeIs('contact'))
    <section class="search-wrap" id="searchWrapSection">
      <form action="{{ route('jobs.index') }}" method="GET" id="headerSearchForm">
      <div class="search-barwrp">
        <div class="field">
          <span class="label">Country:</span>
          <select class="form-control" name="country" id="countrySelect">
              <option value="">Select Country</option>
              @php
                  $countries = \App\Models\Country::where('is_active', true)->orderBy('name')->get();
              @endphp
              @foreach($countries as $country)
                  <option value="{{ $country->name }}" {{ request('country') == $country->name ? 'selected' : '' }}>
                      {{ $country->name }}
                  </option>
              @endforeach
          </select>
        </div> 
        <div class="field">
          <span class="label">State/City:</span>
          <select class="form-control" name="location" id="citySelect">
              <option value="">Select Location</option>
              @php
                  $selectedCountry = request('country');
                  $cities = \App\Models\City::where('is_active', true)
                      ->when($selectedCountry, function($q) use ($selectedCountry) {
                          $q->whereHas('country', function($cq) use ($selectedCountry) {
                              $cq->where('name', 'like', '%' . $selectedCountry . '%');
                          });
                      })
                      ->orderBy('name')
                      ->get();
              @endphp
              @foreach($cities as $city)
                  <option value="{{ $city->name }}" {{ request('location') == $city->name ? 'selected' : '' }}>
                      {{ $city->name }}
                  </option>
              @endforeach
          </select>
        </div>
        <div class="field" style="position: relative;">
          <span class="label">Job Title:</span>
          <input type="text" class="form-control" id="jobTitleInput" name="title" placeholder="e.g. Developer, Designer" value="{{ request('title') }}" autocomplete="off">
          <div id="jobTitleSuggestions" class="autocomplete-suggestions"></div>
        </div>

        <div class="actions">
          <button type="submit" class="btn primary" id="searchBtn" data-text="Search">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="11" cy="11" r="6" stroke="currentColor" fill="none" stroke-width="2"></circle>
              <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
            </svg>
            <span class="search-text">Search</span>
          </button>
        </div>
      </div>
      </form>
    </section>
    
    <style>
    .search-wrap {
        padding: 25px 0;
        margin-top: 20px;
        border-radius: 8px;
    }
    
    .search-barwrp {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .search-barwrp .field {
        flex: 1;
        min-width: 200px;
    }
    
    .search-barwrp .field .label {
        display: block;
        color: #333;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .search-barwrp .field .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #ddd;
        border-radius: 6px;
        background: white;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .search-barwrp .field .form-control:focus {
        outline: none;
        border-color: #007bff;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }
    
    .search-barwrp .actions {
        flex-shrink: 0;
    }
    
    .search-barwrp .btn.primary {
        background: #007bff;
        color: white;
        border: 2px solid #007bff;
        padding: 12px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .search-barwrp .btn.primary:hover {
        background: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .search-barwrp .btn.primary .icon {
        width: 20px;
        height: 20px;
    }
    
    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #ddd;
        border-top: none;
        border-radius: 0 0 6px 6px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .autocomplete-suggestions .autocomplete-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }
    
    .autocomplete-suggestions .autocomplete-item:hover,
    .autocomplete-suggestions .autocomplete-item.active {
        background: #f8f9fa;
    }
    
    @media (max-width: 768px) {
        .search-barwrp {
            flex-direction: column;
            gap: 15px;
        }
        
        .search-barwrp .field {
            width: 100%;
            min-width: auto;
        }
        
        .search-barwrp .actions {
            width: 100%;
        }
        
        .search-barwrp .btn.primary {
            width: 100%;
            justify-content: center;
        }
    }
    </style>
    
    <script>
    // Mobile Menu and Search Toggle
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Loaded - Initializing mobile menu');
        
        // Get all elements
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileNavMenu = document.getElementById('mobileNavMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const searchWrap = document.getElementById('searchWrapSection') || document.querySelector('.search-wrap');
        
        console.log('Elements found:', {
            mobileMenuToggle: !!mobileMenuToggle,
            mobileNavMenu: !!mobileNavMenu,
            mobileMenuOverlay: !!mobileMenuOverlay,
            mobileMenuClose: !!mobileMenuClose,
            mobileSearchToggle: !!mobileSearchToggle,
            searchWrap: !!searchWrap
        });
        
        // Make functions globally available for inline handlers
        window.openMobileMenu = function() {
            console.log('Opening mobile menu');
            const menu = document.getElementById('mobileNavMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            if (menu && overlay) {
                menu.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
                console.log('Menu opened successfully');
            } else {
                console.error('Menu elements not found!', { menu, overlay });
            }
        };
        
        window.closeMobileMenu = function() {
            console.log('Closing mobile menu');
            const menu = document.getElementById('mobileNavMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            if (menu && overlay) {
                menu.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        };
        
        // Local references for internal use
        function openMobileMenu() {
            window.openMobileMenu();
        }
        
        function closeMobileMenu() {
            window.closeMobileMenu();
        }
        
        // Mobile menu toggle button
        if (mobileMenuToggle) {
            console.log('Attaching menu toggle listener to button:', mobileMenuToggle);
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Menu button clicked!', e);
                openMobileMenu();
                return false;
            });
            // Also try direct onclick as backup
            mobileMenuToggle.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Menu button onclick triggered');
                openMobileMenu();
                return false;
            };
        } else {
            console.error('mobileMenuToggle button not found!');
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.stopPropagation();
                closeMobileMenu();
            });
        }
        
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function() {
                closeMobileMenu();
            });
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileNavMenu && mobileNavMenu.classList.contains('show')) {
                const menuToggleBtn = mobileMenuToggle || menuToggle;
                if (menuToggleBtn && !mobileNavMenu.contains(e.target) && !menuToggleBtn.contains(e.target)) {
                    closeMobileMenu();
                }
            }
        });
        
        // Close menu when clicking on menu links
        if (mobileNavMenu) {
            const menuLinks = mobileNavMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(() => {
                        closeMobileMenu();
                    }, 100);
                });
            });
        }
        
        // Make search toggle globally available for inline handlers
        window.toggleMobileSearch = function() {
            console.log('Toggling search');
            const sw = document.getElementById('searchWrapSection') || document.querySelector('.search-wrap');
            if (sw) {
                const isShowing = sw.classList.contains('show');
                console.log('Current search state:', isShowing);
                if (isShowing) {
                    sw.classList.remove('show');
                    sw.style.display = 'none';
                    console.log('Search hidden - class removed');
                } else {
                    sw.classList.add('show');
                    sw.style.display = 'block';
                    console.log('Search shown - class added');
                    // Scroll to search if needed
                    setTimeout(() => {
                        if (sw) {
                            sw.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    }, 100);
                }
                // Close menu if open
                const menu = document.getElementById('mobileNavMenu');
                if (menu && menu.classList.contains('show')) {
                    window.closeMobileMenu();
                }
            } else {
                console.error('Search wrap not found! Trying to find again...');
            }
        };
        
        // Local reference for internal use
        function toggleSearch() {
            window.toggleMobileSearch();
        }
        
        // Mobile search toggle button
        if (mobileSearchToggle) {
            console.log('Attaching search toggle listener to button:', mobileSearchToggle);
            mobileSearchToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Search button clicked!', e);
                toggleSearch();
                return false;
            });
            // Also try direct onclick as backup
            mobileSearchToggle.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Search button onclick triggered');
                toggleSearch();
                return false;
            };
        } else {
            console.error('mobileSearchToggle button not found!');
        }
        
        // Close menu when window is resized to desktop size (Browser Responsive Mode)
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 992) {
                    // Desktop view - close mobile menu if open
                    if (mobileNavMenu && mobileNavMenu.classList.contains('show')) {
                        closeMobileMenu();
                    }
                }
            }, 100);
        });
        
        // Check on page load if mobile view (Browser Responsive Mode)
        function checkMobileView() {
            return window.innerWidth < 992;
        }
        
        // Initialize menu state based on viewport
        if (checkMobileView()) {
            // Mobile view - menu should be hidden by default
            if (mobileNavMenu) {
                mobileNavMenu.classList.remove('show');
                // Ensure menu is in DOM and visible when needed
                mobileNavMenu.style.display = 'block';
            }
            if (mobileMenuOverlay) {
                mobileMenuOverlay.classList.remove('show');
            }
        }
        
        // Debug: Log all menu elements on load
        console.log('Mobile Menu Elements:', {
            mobileMenuToggle: !!mobileMenuToggle,
            mobileNavMenu: !!mobileNavMenu,
            mobileMenuOverlay: !!mobileMenuOverlay,
            mobileMenuClose: !!mobileMenuClose,
            mobileSearchToggle: !!mobileSearchToggle,
            searchWrap: !!searchWrap
        });
        
        // Dynamic city loading based on country selection
        const countrySelect = document.getElementById('countrySelect');
        const citySelect = document.getElementById('citySelect');
        
        if (countrySelect && citySelect) {
            countrySelect.addEventListener('change', function() {
                const country = this.value;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                citySelect.disabled = true;
                
                if (country) {
                    fetch(`{{ url('/api/cities') }}/${encodeURIComponent(country)}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Select Location</option>';
                            if (data.success && data.cities && Array.isArray(data.cities)) {
                                data.cities.forEach(city => {
                                    const option = document.createElement('option');
                                    option.value = city.name;
                                    option.textContent = city.name;
                                    citySelect.appendChild(option);
                                });
                            }
                            citySelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading cities:', error);
                            citySelect.innerHTML = '<option value="">Select Location</option>';
                            citySelect.disabled = false;
                        });
                } else {
                    // Clear cities when no country selected
                    citySelect.innerHTML = '<option value="">Select Location</option>';
                    citySelect.disabled = false;
                }
            });
        }
    });
    </script>
    @endif
    
  </div>
</div>

