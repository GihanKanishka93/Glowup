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
                                    <p class="login-visual-subtitle">Secure Credential Reset</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-user-shield mr-2"></i>Verified recovery session</li>
                                        <li><i class="fas fa-lock mr-2"></i>Encryption-standard security</li>
                                        <li><i class="fas fa-check-circle mr-2"></i>Instant account reactivation</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="text-center mb-4 d-lg-none">
                                        <img src="{{ asset('img/Glowup_Logo-modified.png') }}" alt="Glowup Skin Clinic"
                                            class="login-logo">
                                    </div>
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">Final step</p>
                                        <h1 class="login-title mb-2">Set New Password</h1>
                                        <p class="login-copy mb-0">Complete your recovery by choosing a new password.</p>
                                    </div>

                                    <form action="{{ route('password.update') }}" method="POST" class="user">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="user_name">User name</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input type="text" name="user_name" value="{{ old('user_name') }}"
                                                    class="form-control login-control @error('user_name') is-invalid @enderror"
                                                    id="user_name" placeholder="Your username" required>
                                                @error('user_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="password">New Password</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input type="password" name="password"
                                                    class="form-control login-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="New password" required>
                                                @error('password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                                </div>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control login-control" id="password_confirmation"
                                                    placeholder="Verify password" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Update Password
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a class="small font-weight-bold" href="{{ url('/login') }}">
                                            Back to sign in
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
