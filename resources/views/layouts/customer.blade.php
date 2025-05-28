{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\layouts\customer.blade.php --}}
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
            background: linear-gradient(135deg, #e3eaf5, #f7f9fc);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            scroll-behavior: smooth;
        }
        .navbar-blur {
            background: rgba(30, 41, 59, 0.75) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 1.5px;
        }
        .nav-link {
            transition: all 0.2s ease-in-out;
        }
        .nav-link.active, .nav-link:hover, .nav-link:focus {
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 0.5rem;
        }
        .dropdown-menu {
            border-radius: 1rem;
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.1);
            animation: fadeIn 0.2s ease-in-out;
        }
        .avatar-customer {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(13, 110, 253, 0.2);
        }
        main {
            padding-top: 2rem;
        }
        footer {
            background: #0f172a;
            color: #fff;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(5px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-blur shadow-sm py-2 sticky-top">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('customer.products.index') }}">
                <i class="bi bi-bag-check-fill me-2"></i> UAS PPWL
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCustomer" aria-controls="navbarCustomer" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCustomer">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('customer.products.index') ? ' active' : '' }} text-white" href="{{ route('customer.products.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('cart.*') ? ' active' : '' }} text-white" href="{{ route('customer.cart.index') }}">
                            <i class="bi bi-cart me-1"></i> Keranjang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('customer.orders.index') ? ' active' : '' }} text-white" href="{{ route('customer.orders.index') }}">
                            <i class="bi bi-receipt me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="nav-link text-white" href="{{ route('login') }}">
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
        <small>&copy; {{ date('Y') }} UAS PPWL. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>