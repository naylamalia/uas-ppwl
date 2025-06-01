<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title', 'Admin Panel') - Corporate UI by Creative Tim & UPDIVISION
    </title>
    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Navy Theme Style -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(195deg, #001f3f, #003366) !important;
        }

        .btn.bg-gradient-primary {
            background: linear-gradient(195deg, #001f3f, #003366) !important;
            border: none;
        }

        .btn-outline-dark {
            color: #001f3f;
            border-color: #001f3f;
        }

        .btn-outline-dark:hover {
            background-color: #001f3f;
            color: #fff;
        }

        .text-dark {
            color: #001f3f !important;
        }

        .btn.bg-gradient-dark {
            background: linear-gradient(195deg, #001f3f, #002a52) !important;
        }

        .fixed-plugin-button {
            background-color: #001f3f !important;
        }

        .form-check-input:checked {
            background-color: #001f3f;
            border-color: #001f3f;
        }

        .badge.bg-gradient-primary {
            background: linear-gradient(195deg, #001f3f, #003366) !important;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    {{-- Sidebar khusus admin --}}
    <x-app.sidebar />

    <main class="main-content">
        @yield('content')
    </main>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') }}"></script>
    <script>
        if (document.getElementsByClassName('mySwiper')) {
            var swiper = new Swiper(".mySwiper", {
                effect: "cards",
                grabCursor: true,
                initialSlide: 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>