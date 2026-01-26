@extends('layouts.public')
@section('content')

    <body class="bg-gradient-login login-body">
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-lg-12">
                    <div class="login-shell shadow-lg">
                        <div class="row no-gutters align-items-stretch">
                            <div class="col-lg-5 d-none d-lg-flex login-visual">
                                <div class="login-visual-overlay">
                                    <img src="{{ asset('img/Glowup_Logo-modified.png') }}" alt="Glowup Skin Clinic"
                                        class="login-logo mb-4">
                                    <h2 class="login-visual-title">Glowup Identity</h2>
                                    <p class="login-visual-subtitle">High-Security Verification</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-user-lock mr-2"></i>Double-authenticated session</li>
                                        <li><i class="fas fa-shield-check mr-2"></i>Protected clinical data</li>
                                        <li><i class="fas fa-history mr-2"></i>Audit-logged security event</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">Confirm identity</p>
                                        <h1 class="login-title mb-2">Secure Access</h1>
                                        <p class="login-copy mb-0">Please confirm your password before continuing to this
                                            sensitive area.</p>
                                    </div>

                                    <form method="POST" action="{{ route('password.confirm') }}" class="user">
                                        @csrf

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="password">Current Password</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input type="password" name="password"
                                                    class="form-control login-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="Verify password" required
                                                    autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Confirm Access
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a class="small font-weight-bold" href="{{ route('password.request') }}">
                                            Forgot Your Password?
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