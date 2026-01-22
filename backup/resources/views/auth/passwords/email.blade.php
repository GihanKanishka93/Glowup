<x-laravel-ui-adminlte::adminlte-layout>

<body class="bg-gradient-login">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 card_login">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                            @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @endif
                                    </div>
                                    <form class="user" action="{{ route('password.email') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user {{ $errors->has('user_name') ? ' is-invalid' : '' }}"
                                                id="exampleInputEmail" name="user_name" aria-describedby="emailHelp"
                                                placeholder="Enter User name...">
                                                @if ($errors->has('user_name'))
                                                <span class=" invalid-feedback">{{ $errors->first('user_name') }}</span>
                                                @endif
                                        </div>
                                        {{-- <a href="login.php" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </a> --}}
                                        <button type="submit" class="btn btn-primary btn-user btn-block"> Reset Password</button>
                                    </form>
                                    <hr>
                                    <div class="text-center"> 
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
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
</x-laravel-ui-adminlte::adminlte-layout>
