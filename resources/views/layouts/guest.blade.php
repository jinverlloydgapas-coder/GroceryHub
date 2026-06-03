<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GroceryHub') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #34d399;
            --primary-lighter: #d1fae5;
            --secondary: #8b6f47;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f9fafb;
            --border-light: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Guest Navbar */
        .navbar-guest {
            background: white;
            border-bottom: 1px solid var(--border-light);
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand-guest {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary) !important;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand-guest i {
            font-size: 1.8rem;
        }

        .navbar-nav-guest {
            margin-left: auto;
        }

        .nav-link-guest {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin-left: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-guest:hover {
            color: var(--primary) !important;
        }

        .nav-link-guest.btn-login {
            border: 2px solid var(--primary);
            color: var(--primary) !important;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-link-guest.btn-signup {
            background: var(--primary);
            color: white !important;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            margin-left: 0.75rem;
            transition: all 0.3s ease;
        }

        .nav-link-guest.btn-login:hover {
            background: var(--primary-lighter);
        }

        .nav-link-guest.btn-signup:hover {
            background: var(--primary-dark);
        }

        /* Hamburger Menu */
        .hamburger-menu {
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hamburger-menu:hover {
            color: var(--primary-dark) !important;
        }

        /* Desktop Menu */
        @media (min-width: 768px) {
            .desktop-menu {
                display: flex !important;
            }
        }

        /* Main Content */
        .main-content-guest {
            flex: 1;
        }

        /* Auth Cards */
        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-light);
            padding: 2.5rem;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: block;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1.5px solid var(--border-light);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            color: var(--text-dark);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .btn-primary-guest {
            background: var(--primary);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .btn-primary-guest:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-primary-guest:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        .auth-footer p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block !important;
        }

        .is-invalid {
            border-color: #dc2626 !important;
        }

        /* Footer */
        .footer-guest {
            background: white;
            border-top: 1px solid var(--border-light);
            padding: 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .footer-guest a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-guest a:hover {
            color: var(--primary-dark);
        }

        /* Role Selector */
        .role-selector {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .role-option {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            border: 2px solid var(--border-light);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-option:hover {
            border-color: var(--primary);
            background: var(--primary-lighter);
        }

        .role-option input[type="radio"] {
            margin-top: 2px;
            cursor: pointer;
        }

        .role-option input[type="radio"]:checked + label {
            color: var(--text-dark);
        }

        .role-option input[type="radio"]:checked ~ .role-badge {
            font-weight: 700;
        }

        .role-option label {
            margin-bottom: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            margin-left: 0.5rem;
        }

        .role-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
            display: inline-block;
        }

        .role-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .role-option input[type="radio"]:checked + label .role-text {
            color: var(--text-dark);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-guest">
        <div class="container-fluid">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <!-- Brand -->
                <a class="navbar-brand-guest" href="{{ route('home') }}">
                    <i class="fas fa-leaf"></i>
                    <span>GroceryHub</span>
                </a>

                <!-- Desktop Menu -->
                <div style="display: none;" class="desktop-menu">
                    <div style="display: flex; gap: 2rem; align-items: center;">
                        <a href="{{ route('home') }}" class="nav-link-guest">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                        <a href="{{ route('home') }}#grocery" class="nav-link-guest">
                            <i class="fas fa-shopping-cart me-2"></i>Grocery
                        </a>
                        <a href="#about" class="nav-link-guest">
                            <i class="fas fa-info-circle me-2"></i>About Us
                        </a>
                    </div>
                </div>

                <!-- Right Section -->
                <div style="display: flex; gap: 1rem; align-items: center;">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link-guest btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                        <a href="{{ route('signup') }}" class="nav-link-guest btn-signup">
                            <i class="fas fa-user-plus me-2"></i>Sign Up
                        </a>
                    @else
                        <button class="hamburger-menu" onclick="toggleMenu()" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: var(--primary);">
                            <i class="fas fa-bars"></i>
                        </button>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Authenticated User Dropdown Menu -->
    @auth
        <div id="userMenu" class="user-menu" style="display: none; position: fixed; top: 70px; right: 20px; background: white; border: 1px solid var(--border-light); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000;">
            <div style="padding: 1rem; border-bottom: 1px solid var(--border-light);">
                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">{{ Auth::user()->name }}</p>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">
                    @if(Auth::user()->isAdmin())
                        <span style="display: inline-block; background: var(--primary); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Admin</span>
                    @else
                        <span style="display: inline-block; background: #9ca3af; color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Customer</span>
                    @endif
                </p>
            </div>
            
            @if(Auth::user()->isAdmin())
                <!-- Admin Menu Items -->
                <a href="{{ route('admin.dashboard') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-chart-line" style="color: var(--primary);"></i>Admin Dashboard
                </a>
                <a href="{{ route('users.index') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-users"></i>Manage Users
                </a>
                <a href="{{ route('tasks.index') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-shopping-cart"></i>Manage Catalog
                </a>
                <a href="{{ route('profile.edit') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid var(--border-light);" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-cog"></i>Settings
                </a>
            @else
                <!-- Customer Menu Items -->
                <a href="{{ route('profile.edit') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-user"></i>Profile
                </a>
                <a href="{{ route('profile.edit') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-cog"></i>Settings
                </a>
                <a href="{{ route('tasks.index') }}" class="menu-item" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid var(--border-light);" onmouseover="this.style.background='var(--primary-lighter)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-list"></i>Grocery List
                </a>
            @endif
            
            <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                @csrf
                <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0.75rem 1rem; color: #dc2626; cursor: pointer; font-size: 1rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(220, 38, 38, 0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    @endauth

    <!-- Main Content -->
    <div class="main-content-guest">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer-guest">
        <div class="container-fluid">
            <p>&copy; {{ date('Y') }} GroceryHub. All rights reserved. | 
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('userMenu');
            if (menu) {
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const hamburger = document.querySelector('.hamburger-menu');
            if (menu && !menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
