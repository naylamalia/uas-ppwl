@section('title', 'Forgot Password')
<x-guest-layout>
    <main class="main-content mt-0"
        style="background:white; min-height:100vh;">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8 shadow"
                                style="border:1.5px solid firebrick; background:#fff5f5;">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h3 class="font-weight-black" style="color:firebrick;">Forgot password?</h3>
                                    <p class="mb-0 text-firebrick">Enter your email below!</p>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger text-sm" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                                @if (session('status'))
                                    <div class="alert alert-info text-sm" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger text-sm" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="card-body">
                                    <form role="form" action="/forgot-password" method="POST">
                                        {{ csrf_field() }}
                                        <label class="text-firebrick">Email Address</label>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" placeholder="Email"
                                                aria-label="Email" id="email" name="email"
                                                value="{{ old('email') }}" required autofocus
                                                style="border-color:firebrick; background:white;">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn w-100 mt-4 mb-3"
                                                style="background:firebrick; color:#fff;">Email password reset link
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto text-firebrick">
                                        Remember your password?
                                        <a href="{{ route('sign-in') }}"
                                            class="font-weight-bold text-firebrick">Sign in</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                                    style="background-image:url('../assets/img/image-sign-in.jpg')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @push('styles')
    <style>
        .text-firebrick {
            color: firebrick !important;
        }

        .form-control:focus {
            border-color: firebrick !important;
            box-shadow: 0 0 0 0.1rem rgba(178, 34, 34, 0.15);
        }

        .btn-firebrick,
        .btn-firebrick:focus,
        .btn-firebrick:hover {
            background: firebrick !important;
            color: #fff !important;
            border-color: firebrick !important;
        }

        .card {
            border-radius: 1.25rem;
        }
    </style>
    @endpush
</x-guest-layout>
