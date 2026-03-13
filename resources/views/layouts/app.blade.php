<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NVS-System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            background-color: #0b1020;
        }

        .custom-navbar {
            background: linear-gradient(135deg, #0a1020, #101a35, #16213e);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .navbar {
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
            color: #ffffff !important;
        }

        .navbar-brand i {
            margin-right: 6px;
            color: #7dd3fc;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.78) !important;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #ffffff !important;
        }

        .dropdown-menu {
            background: rgba(18, 25, 45, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(12px);
        }

        .dropdown-item {
            color: #e5e7eb;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.08);
        }

        .card {
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: #f8f9fa;
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 4px;
            margin-bottom: 2px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #e9ecef;
        }

        footer {
            margin-top: auto;
            background: rgba(8, 12, 24, 0.92) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        footer p {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    </style>

    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-shield-check"></i> NVS-System
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.password') }}">Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

    <footer class="py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} NVS-System - News Verification System</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>