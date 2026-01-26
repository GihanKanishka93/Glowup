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
                                    <h2 class="login-visual-title">Join Glowup</h2>
                                    <p class="login-visual-subtitle">Clinical Management Environment</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-id-card mr-2"></i>Personalized practitioner profile</li>
                                        <li><i class="fas fa-clock mr-2"></i>Shared clinical scheduling</li>
                                        <li><i class="fas fa-lock mr-2"></i>Standardized security protocols</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">New account</p>
                                        <h1 class="login-title mb-2">Create Profile</h1>
                                        <p class="login-copy mb-0">Set up your practitioner credentials to get started.</p>
                                    </div>

                                    <form method="POST" action="{{ route('register') }}" class="user">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Full Name</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    class="form-control login-control @error('name') is-invalid @enderror"
                                                    id="name" placeholder="E.g. Dr. John Doe" required>
                                                @error('name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="email">Work Email</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                                </div>
                                                <input type="email" name="email" value="{{ old('email') }}"
                                                    class="form-control login-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="email@glowup.com" required>
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="password">Password</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="password" name="password"
                                                            class="form-control login-control @error('password') is-invalid @enderror"
                                                            id="password" placeholder="Secure pwd" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="password_confirmation">Confirm</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control login-control" id="password_confirmation"
                                                            placeholder="Verify pwd" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-4 mt-2">
                                            <input type="checkbox" class="custom-control-input" id="agreeTerms" name="terms"
                                                value="agree" required>
                                            <label class="custom-control-label small" for="agreeTerms">I agree to the clinic
                                                standards and terms.</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Register account
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a class="small font-weight-bold" href="{{ route('login') }}">
                                            Already a member? Sign in
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