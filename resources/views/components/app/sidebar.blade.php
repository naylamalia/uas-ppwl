{{-- filepath: c:\laragon\www\uas-ppwl\resources\views\components\app\sidebar.blade.php --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start"
    id="sidenav-main"
    style="background-color:firebrick">
    <style>
    /* Cegah perubahan warna saat hover dan aktif */
    .nav-link {
        color: white !important;
        background-color: firebrick !important;
    }

    .nav-link:hover,
    .nav-link:focus,
    .nav-link:active {
        color: white !important;
        background-color: firebrick !important;
        box-shadow: none !important;
    }

    .nav-link.active {
        color: white !important;
        background-color: firebrick !important;
    }

    /* Jika ingin ikon juga tidak berubah warna */
    .nav-link i {
        color: white !important;
    }

    .nav-link:hover i,
    .nav-link.active i {
        color: white !important;
    }
</style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none "
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0"
            href="@if(auth()->check() && auth()->user()->hasRole('admin'))
                    {{ route('admin.dashboard') }}
                @elseif(auth()->check() && auth()->user()->hasRole('customer'))
                    {{ route('customer.dashboard') }}
                @else
                    {{ route('dashboard') }}
                @endif">
            <span class="font-weight-bold text-lg d-flex align-items-center position-relative text-white">
                PocketGear
                <span style="position:relative; display:inline-block; width:1.8rem; height:1.8rem; margin-left:0.5rem;">
                    <i class="bi bi-gear text-white" style="font-size:1.8rem; color:#212529; position:absolute; left:0; top:0;"></i>
                </span>
            </span>
        </a>
    </div>
    <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if(auth()->check() && auth()->user()->hasRole('admin'))
                {{-- MENU UNTUK ADMIN --}}
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-house-door" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management.index') ? 'active' : '' }}"
                        href="{{ route('admin.users-management.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-people" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kelola Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-seam" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('admin.stock.index') ? 'active' : '' }}" href="{{ route('admin.stock.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-archive" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Stok Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-receipt" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pesanan</span>
                    </a>
                </li>
            @elseif(auth()->check() && auth()->user()->hasRole('customer'))
                {{-- MENU UNTUK CUSTOMER --}}
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('customer.products.index') ? 'active' : '' }}" href="{{ route('customer.products.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-seam" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('customer.cart.index') ? 'active' : '' }}" href="{{ route('customer.cart.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Keranjang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('customer.orders.index') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-receipt" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pesanan Saya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_current_route('customer.profile') ? 'active' : '' }}" href="{{ route('customer.profile') }}">
                        <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-person" style="font-size:1.5rem;"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profil</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    {{-- Sign Out pindah ke paling bawah sidebar --}}
    <div class="sidenav-footer mx-4 mt-auto" style="margin-top:auto;">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button"
                id="custom-logout-btn"
                class="nav-link d-flex align-items-center position-relative ms-0 ps-2 py-2 w-100 text-start"
                style="background:none; border:none;">
                <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-right" style="font-size:1.5rem; color:white;"></i>
                </div>
                <span class="nav-link-text ms-1 text-white">Sign Out</span>
            </button>
        </form>
    </div>

    <!-- Custom Logout Modal (styled like delete user modal) -->
    <div class="modal" tabindex="-1" id="logoutModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3);">
        <div style="background:#fff; max-width:350px; margin:10% auto; border-radius:8px; box-shadow:0 2px 8px #0002; padding:24px; text-align:center;">
            <div class="mb-3">
                <i class="bi bi-box-arrow-right" style="font-size:2.5rem; color:firebrick;"></i>
            </div>
            <div class="mb-3">
                <div class="fw-bold mb-2">Yakin ingin keluar dari akun?</div>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <button type="button" id="cancelLogout" class="btn btn-secondary btn-sm px-4">Batal</button>
                <button type="button" id="confirmLogout" class="btn btn-danger btn-sm px-4">Keluar</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('custom-logout-btn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logout-form');

        if (logoutBtn && logoutModal && cancelLogout && confirmLogout && logoutForm) {
            logoutBtn.addEventListener('click', function () {
                logoutModal.style.display = 'block';
            });
            cancelLogout.addEventListener('click', function () {
                logoutModal.style.display = 'none';
            });
            confirmLogout.addEventListener('click', function () {
                logoutForm.submit();
            });
            // Optional: close modal if click outside modal box
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) logoutModal.style.display = 'none';
            });
        }
    });
    </script>
</aside>