<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Area')</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    @stack('styles')
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #4b4b4b;
        }

        .navbar-blur {
            background: #fff !important;
            border-bottom: 1px solid firebrick;
            box-shadow: 0 8px 20px rgba(178, 34, 34, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: firebrick;
            letter-spacing: 1.2px;
        }

        .nav-link {
            color: firebrick;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease-in-out;
        }

        .nav-link.active,
        .nav-link:hover,
        .nav-link:focus {
            background-color: rgba(178, 34, 34, 0.08);
            border-radius: 0.75rem;
            color: firebrick;
        }

        .dropdown-menu {
            border-radius: 1rem;
            box-shadow: 0 1.5rem 2rem rgba(0,0,0,0.1);
            animation: fadeIn 0.3s ease-in-out;
        }

        .avatar-customer {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid firebrick;
        }

        main {
            padding: 3rem 1rem;
        }

        footer {
            background: #fff;
            color: firebrick;
            text-shadow: none;
            font-size: 0.9rem;
            border-top: 1px solid firebrick;
        }

        .btn-primary,
        .btn-outline-primary,
        .btn-outline-danger,
        .btn-outline-secondary {
            border-color: firebrick !important;
            color: firebrick !important;
            background: #fff !important;
        }

        .btn-primary:hover,
        .btn-outline-primary:hover,
        .btn-outline-danger:hover,
        .btn-outline-secondary:hover {
            background: firebrick !important;
            color: #fff !important;
        }

        .card, .card-body {
            background: #fff !important;
        }

        .card-header, .border-bottom {
            background: #fff !important;
            border-color: firebrick !important;
        }

        .card-header h5, .fw-bold, .text-dark, .card-header, .fs-4, .font-weight-bold {
            color: firebrick !important;
        }

        .list-group-item {
            background: #fff !important;
        }

        .border, .card.border {
            border-color: firebrick !important;
        }

        .table th, .table td {
            color: firebrick !important;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(8px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-blur shadow-sm py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
                <i class="bi bi-gem me-2"></i> PocketGrip
            </a>
            <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCustomer" aria-controls="navbarCustomer" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCustomer">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('customer.products.index') ? ' active' : '' }}" href="{{ route('customer.products.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('cart.*') ? ' active' : '' }}" href="{{ route('customer.cart.index') }}">
                            <i class="bi bi-cart me-1"></i> Keranjang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('customer.orders.index') ? ' active' : '' }}" href="{{ route('customer.orders.index') }}">
                            <i class="bi bi-receipt me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/img/team-2.jpg') }}" alt="avatar" class="avatar-customer me-2">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="navbarUser">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 container">
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto">
        <small>&copy; {{ date('Y') }} PocketGrip by UAS PPWL. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>