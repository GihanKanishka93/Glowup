@extends('layouts.public')
@section('content')

    <body class="login-body">
        <!-- Dedicated Animation Backdrop (Isolated from Logo) -->
        <div class="bg-gradient-login"></div>
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-lg-12">
                    <div class="login-shell shadow-lg">
                        <div class="row no-gutters align-items-stretch">
                            <div class="col-lg-5 d-none d-lg-flex login-visual">
                                <div class="login-visual-overlay">
                                    <video class="login-logo-video mb-4" autoplay muted playsinline preload="auto"
                                        poster="{{ asset('img/Glowup_Logo-modified.png') }}"
                                        aria-label="Glowup Skin Clinic logo animation">
                                        <source src="{{ asset('img/Logo_Animation_Video_Ready.mp4') }}"
                                            type="video/mp4">
                                    </video>
                                    <h2 class="login-visual-title">Glowup Skin Clinic</h2>
                                    <p class="login-visual-subtitle">Password Recovery Workspace</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-shield-alt mr-2"></i>Secure automated reset link</li>
                                        <li><i class="fas fa-key mr-2"></i>Choose a strong new password</li>
                                        <li><i class="fas fa-user-check mr-2"></i>Instant access after recovery</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="text-center mb-4 d-lg-none">
                                        <video class="login-logo-video" autoplay muted playsinline preload="auto"
                                            poster="{{ asset('img/Glowup_Logo-modified.png') }}"
                                            aria-label="Glowup Skin Clinic logo animation">
                                            <source src="{{ asset('img/Logo_Animation_Video_Ready.mp4') }}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">Reset requested</p>
                                        <h1 class="login-title mb-2">Forgot Password?</h1>
                                        <p class="login-copy mb-0">Enter your user name and we'll send you a recovery link.
                                        </p>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('status') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('password.email') }}" method="POST">
                                        @csrf

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="loginUserName">User name</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input type="text" name="user_name" value="{{ old('user_name') }}"
                                                    class="form-control login-control @error('user_name') is-invalid @enderror"
                                                    id="loginUserName" placeholder="Your username" required>
                                                @error('user_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Send reset link
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a class="small font-weight-bold" href="{{ url('/login') }}">
                                            <i class="fas fa-arrow-left mr-1"></i> Back to sign in
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection()
