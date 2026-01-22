<x-laravel-ui-adminlte::adminlte-layout>

    <body class="bg-gradient-login ">
        <div class="container ">


            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">


                    <div class="card o-hidden border-0 shadow-lg my-5 card_login ">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <h1 class="h4 text-gray-900 mb-4 login_title">Reset Password</h1>
    
                            <p class="slogan">You are only one step a way from your new password, recover your
                                password
                                now.</p>

                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf

                                @php
                                    if (!isset($token)) {
                                        $token = \Request::route('token');
                                    }
                                @endphp

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="input-group mb-3 {{ $errors->has('user_name') ? ' is-invalid' : '' }}">
                                    <input type="user_name" name="user_name"
                                        class="form-control form-control-user  "
                                        placeholder="User Name">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                                    </div>
                                   
                                </div>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif

                                <div class="input-group mb-3 {{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <input type="password" name="password"
                                        class="form-control "
                                        placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                    </div>
                                    
                                </div>@if ($errors->has('password'))
                                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif

                                <div class="input-group mb-3 {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                    </div>
                                    
                                </div>
                                @if ($errors->has('password_confirmation'))
                                        <span
                                            class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                    @endif

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                            <p class="mt-3 mb-1">
                                <a href="{{ route('login') }}">Login</a>
                            </p>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
