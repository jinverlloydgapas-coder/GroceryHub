<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Grocery List') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #34d399;
            --sidebar-bg: #065f46;
            --sidebar-hover: #10b981;
            --border-color: rgba(16,185,129,.12);
            --text-muted: #6b7280;
            --success: #059669;
            --danger: #dc2626;
            --warning: #f97316;
        }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        html, body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            background: #f8fafc;
            color: #1f2937;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            body {
                flex-direction: row;
            }
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, var(--sidebar-bg) 0%, #047857 100%);
            color: white;
            width: 100%;
            max-width: 270px;
            height: auto;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            order: 2;
        }

        @media (min-width: 768px) {
            .sidebar {
                height: 100vh;
                position: sticky;
                top: 0;
                order: 1;
                flex-shrink: 0;
            }
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            padding: 15px;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.02em;
        }

        .sidebar-header i {
            font-size: 1.8rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 8px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .sidebar-nav a:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar-nav a.active {
            background: var(--sidebar-hover);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar-nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: #34d399;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-nav i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-user {
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 15px;
            margin-top: 30px;
            margin-bottom: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sidebar-user-details .user-name {
            font-weight: 600;
            color: white;
            font-size: 0.95rem;
        }

        .sidebar-user-details .user-email {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            order: 1;
        }

        @media (min-width: 768px) {
            .main-content {
                order: 2;
            }
        }

        /* Navbar Styles */
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .02em;
            color: #111827 !important;
            font-size: 1.35rem;
        }

        .nav-link {
            color: var(--primary-light) !important;
            font-weight: 500;
            transition: all 0.25s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-dark) !important;
        }

        .nav-link.active {
            color: var(--primary-dark) !important;
            font-weight: 600;
        }

        .main-container {
            padding: 2rem;
            flex: 1;
        }

        /* Card Styles */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .card:hover {
            border-color: rgba(148,163,184,.2);
            box-shadow: 0 10px 32px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }

        .card {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-body {
            padding: 2rem;
        }

        /* Button Styles */
        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(51,65,85,.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 8px 25px rgba(31,41,55,.4);
            transform: translateY(-2px);
            color: white;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-secondary {
            border: 1px solid var(--border-color);
            color: var(--primary-light);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: rgba(51,65,85,.05);
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-danger {
            border: 1px solid var(--danger);
            color: var(--danger);
            font-weight: 500;
        }

        .btn-outline-danger:hover {
            background-color: rgba(220,38,38,.05);
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-left: 8px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Form Styles */
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 0.85rem;
            border-color: #cbd5e1;
            background: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,.1), 0 0 0 1px #7c3aed;
            background: #faf9f9;
            transform: translateY(-1px);
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='12 12 24 24'%3e%3ccircle cx='24' cy='24' r='11' fill='none' stroke='%23dc2626' stroke-width='2'/%3e%3cpath fill='%23dc2626' d='M24 16v8M24 27a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(220,38,38,.1), 0 0 0 1px #dc2626;
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--danger);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .valid-feedback {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--success);
            animation: fadeIn 0.3s ease;
        }

        .form-control-lg {
            padding: 0.875rem 1.25rem;
            border-radius: 0.9rem;
        }

        .table {
            border-radius: 1.1rem;
            overflow: hidden;
            background: #ffffff;
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 1px solid rgba(148,163,184,.15);
            background: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 1rem 1.5rem;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(148,163,184,.08);
            transition: all 0.2s ease;
            animation: fadeInUp 0.5s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
            transform: translateX(2px);
        }

        .table td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            animation: fadeIn 0.5s ease;
        }

        .empty-state-icon {
            font-size: 3rem;
            opacity: 0.3;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .toast {
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 20px 65px -30px rgba(15,23,42,.5);
            animation: slideIn 0.3s ease forwards;
            backdrop-filter: blur(10px);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast-body {
            font-size: 0.96rem;
            font-weight: 500;
        }

        .toast-success {
            background: linear-gradient(135deg, var(--success) 0%, #047857 100%);
            color: white;
        }

        .toast-error {
            background: linear-gradient(135deg, var(--danger) 0%, #b91c1c 100%);
            color: white;
        }

        /* Toastr green notification styling */
        #toast-container > .toast {
            background-image: none !important;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        #toast-container > .toast.toast-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        #toast-container > .toast.toast-error {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        #toast-container > .toast.toast-warning {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        #toast-container > .toast.toast-info {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .toast-message {
            color: white !important;
        }

        .badge {
            font-weight: 600;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
        }

        .badge.bg-secondary {
            background: rgba(148,163,184,.15) !important;
            color: #475569;
        }

        .badge.bg-light {
            background: rgba(51,65,85,.05) !important;
            color: #334155;
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: slideInDown 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            border: none;
            border-bottom: 1px solid rgba(148,163,184,.1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(148,163,184,.1);
            padding: 1.5rem 2rem;
            background: #f8fafc;
        }

        .btn-close {
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            transform: scale(1.1);
        }

        .list-group-item {
            border-color: rgba(148,163,184,.1);
            background: transparent;
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background: rgba(51,65,85,.02);
            transform: translateX(4px);
        }

        .mb-3 {
            margin-bottom: 1.25rem !important;
        }

        .mb-4 {
            margin-bottom: 1.75rem !important;
        }

        .form-label {
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .input-group {
            gap: 0.5rem;
        }

        .input-group .form-control,
        .input-group .btn {
            transition: all 0.3s ease;
        }

        .input-group:focus-within .form-control {
            border-color: #7c3aed;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #111827;
        }

        .text-muted {
            color: #64748b !important;
        }

        .display-5 {
            font-weight: 700;
            color: #1f2937;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

        .fw-500 {
            font-weight: 500 !important;
        }

        .rounded-3 {
            border-radius: 0.75rem !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .link-primary {
            color: #7c3aed;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .link-primary:hover {
            color: #6d28d9;
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
        }

        ::placeholder {
            color: #94a3b8;
            opacity: 0.7;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Pagination */
        .pagination {
            gap: 4px;
        }

        .page-link {
            border-radius: 0.5rem;
            border: 1px solid rgba(148,163,184,.2);
            color: var(--primary);
            transition: all 0.2s ease;
            margin: 0 2px;
        }

        .page-link:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(51,65,85,.15);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(51,65,85,.2);
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Badge enhancements */
        .badge {
            font-weight: 600;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                max-width: 100%;
                height: auto;
                margin-bottom: 20px;
                order: 2;
            }

            .main-content {
                order: 1;
            }

            .sidebar-nav a {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .table td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .display-5 {
                font-size: 1.8rem;
            }

            .d-grid {
                gap: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding: 1rem;
            }

            .navbar {
                padding: 0.75rem 1rem;
            }

            .card {
                border-radius: 0.8rem;
            }

            .btn {
                border-radius: 0.6rem;
                padding: 0.6rem 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @auth
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-shopping-list"></i>
            <span>GroceryHub</span>
        </div>

        <ul class="sidebar-nav">
            @if(auth()->user()->role === 'admin')
                <!-- Admin Navigation -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="@request()->routeIs('admin.dashboard') ? 'active' : ''">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Admin Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.create') }}" class="@request()->routeIs('admin.products.create') ? 'active' : ''">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="@request()->routeIs('admin.products.*') ? 'active' : ''">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Manage Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="@request()->routeIs('admin.users.*') ? 'active' : ''">
                        <i class="fas fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
            @else
                <!-- Customer Navigation -->
                <li>
                    <a href="{{ route('dashboard') }}" class="@request()->routeIs('dashboard') ? 'active' : ''">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tasks.index') }}" class="@request()->routeIs('tasks.*') ? 'active' : ''">
                        <i class="fas fa-list"></i>
                        <span>My Grocery List</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('home') }}" class="@request()->routeIs('home') ? 'active' : ''">
                    <i class="fas fa-leaf"></i>
                    <span>Fresh Grocery</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="@request()->routeIs('profile.*') ? 'active' : ''">
                    <i class="fas fa-user-circle"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="sidebar-user-info">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset(Auth::user()->profile_photo) }}" alt="Profile" class="sidebar-user-avatar" style="width:40px;height:40px;object-fit:cover;">
                @else
                    <div class="sidebar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                @endif
                <div class="sidebar-user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                    <div style="margin-top: 8px;">
                        @if(Auth::user()->role === 'admin')
                            <span style="background: #fbbf24; color: #78350f; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">admin</span>
                        @else
                            <span style="background: #34d399; color: #065f46; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">customer</span>
                        @endif
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100" style="color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
    @endauth

    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                @guest
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <i class="fas fa-shopping-list me-2"></i>Grocery List
                    </a>
                @else
                    <span class="navbar-brand" style="cursor: default;">
                        <i class="fas fa-shopping-list me-2"></i>Grocery List
                    </span>
                @endguest

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                            <li class="nav-item"><a class="nav-link{{ request()->routeIs('login') ? ' active' : '' }}" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
                            <li class="nav-item"><a class="nav-link{{ request()->routeIs('register') ? ' active' : '' }}" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Register</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Container -->
        <div class="main-container">
        <!-- Toast Container -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060;" id="toastContainer"></div>

        @yield('content')
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Toast notification setup
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{ $error }}');
        @endforeach
    @endif

    // Form submission handling
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }
        });
    });

    // Add smooth page transitions
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.card').forEach((el, index) => {
            el.style.animationDelay = (index * 50) + 'ms';
        });
    });

    // Delete confirmation helper
    function confirmDelete(message = 'Are you sure?') {
        return confirm(message);
    }
</script>
@stack('scripts')
</body>
</html>
