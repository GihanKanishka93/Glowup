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
                                    <p class="login-visual-subtitle">Skincare & Aesthetics Management Portal</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-calendar-check mr-2"></i>Streamlined check-ins and appointments
                                        </li>
                                        <li><i class="fas fa-heartbeat mr-2"></i>Treatment plans and progress in one place
                                        </li>
                                        <li><i class="fas fa-shield-alt mr-2"></i>Secure access for the team</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="d-flex justify-content-between align-items-start mb-4">
                                        <div>
                                            <p class="eyebrow text-primary mb-1">Welcome back</p>
                                            <h1 class="login-title mb-2">Sign in</h1>
                                            <p class="login-copy mb-0">Access your dashboard to keep the day moving.</p>
                                        </div>
                                        <div class="login-badges text-right d-none d-md-block">
                                            <span class="badge badge-pill badge-soft mr-1">Team</span>
                                            <span class="badge badge-pill badge-soft">Secure</span>
                                        </div>
                                    </div>
                                    <form class="user" action="{{ url('/login') }}" method="POST">
                                        @csrf
                                        @if($errors->any())
                                            <div class="alert alert-dismissible alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <span class="font-weight-bold">Login error:</span> Please check your username
                                                and password.
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label class="form-label" for="loginUserName">User name</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input type="text" name="user_name" value="{{ old('user_name') }}"
                                                    class="form-control login-control @error('user_name') is-invalid @enderror"
                                                    id="loginUserName" placeholder="Your username">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="loginPassword">Password</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input type="password" name="password"
                                                    class="form-control login-control @error('password') is-invalid @enderror"
                                                    id="loginPassword" placeholder="Your password">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="rememberCheck"
                                                    name="remember">
                                                <label class="custom-control-label" for="rememberCheck">Remember me</label>
                                            </div>
                                            <a class="small text-left" href="{{ route('password.request') }}">Forgot
                                                password?</a>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Continue to dashboard
                                        </button>
                                    </form>
                                    <div class="login-footnote mt-4">
                                        <div class="d-flex align-items-center">
                                            <div class="login-avatar mr-3">
                                                <i class="fas fa-clinic-medical"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small mb-1">Clinic uptime</div>
                                                <div class="font-weight-bold text-dark">99.9%</div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-muted small mb-1">Support</div>
                                                <div class="font-weight-bold text-dark">Hotline & email</div>
                                            </div>
                                        </div>
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
