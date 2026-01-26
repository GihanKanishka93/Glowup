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
                                    <h2 class="login-visual-title">Action Required</h2>
                                    <p class="login-visual-subtitle">Secure Account Activation</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-envelope-open-text mr-2"></i>Inbox verification required</li>
                                        <li><i class="fas fa-user-lock mr-2"></i>Confirmed identity access</li>
                                        <li><i class="fas fa-shield-alt mr-2"></i>Account protection protocol</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">Verify email</p>
                                        <h1 class="login-title mb-2">Check Your Inbox</h1>
                                        <p class="login-copy mb-0">Before proceeding, please click the verification link we
                                            just sent to your email address.</p>
                                    </div>

                                    @if (session('resent'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle mr-2"></i> A fresh verification link has been sent.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="card bg-light border-0 rounded-lg p-4 mb-4">
                                        <p class="small text-muted mb-0">If you did not receive the email, please check your
                                            spam folder or request a new link below.</p>
                                    </div>

                                    <form id="resend-form" action="{{ route('verification.resend') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Request Another Link
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-link small font-weight-bold text-decoration-none">
                                                <i class="fas fa-sign-out-alt mr-1"></i> Sign out and try later
                                            </button>
                                        </form>
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