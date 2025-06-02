<x-guest-layout>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row"></div>
    </div>
    <main class="main-content mt-0"
        style="min-height:100vh;">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8 shadow"
                                style="border:1.5px solid firebrick; background:#fff5f5;">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h3 class="font-weight-black" style="color:firebrick;">Welcome back</h3>
                                </div>
                                <div class="text-center">
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @error('message')
                                        <div class="alert alert-danger text-sm" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="card-body">
                                    <form role="form" class="text-start" method="POST" action="sign-in">
                                        @csrf
                                        <label class="text-firebrick">Email Address</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter your email address"
                                                value="{{ old('email') ? old('email') : '' }}"
                                                aria-label="Email" aria-describedby="email-addon"
                                                style="border-color:firebrick; background:white;">
                                        </div>
                                        <label class="text-firebrick">Password</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password"
                                                value="{{ old('password') ? old('password') : '' }}"
                                                class="form-control" placeholder="Enter password" aria-label="Password"
                                                aria-describedby="password-addon"
                                                style="border-color:firebrick; background:white;">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-check-info text-left mb-0">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="font-weight-normal text-firebrick mb-0"
                                                    for="flexCheckDefault">
                                                    Remember for 14 days
                                                </label>
                                            </div>
                                            <a href="{{ route('password.request') }}"
                                                class="text-xs font-weight-bold ms-auto text-firebrick">Forgot
                                                password</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn w-100 mt-4 mb-3"
                                                style="background:firebrick; color:#fff;">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto text-firebrick">
                                        Don't have an account?
                                        <a href="{{ route('sign-up') }}"
                                            class="font-weight-bold text-firebrick">Sign up</a>
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
