@extends('layouts.public')
@section('content')
    <body class="bg-gradient-login ">
        <div class="container ">
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">


                    <div class="card o-hidden border-0 shadow-lg my-5 card_login ">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4 system_title">Challenger Vet Hospital</h1>
                                            <h1 class="slogan">(Veterinary Clinic Management System)</h1>
                                            <h1 class="h4 text-gray-900 mb-4 login_title">Login now</h1>

                                        </div>
                                        <form class="user" action="{{ url('/login') }}" method="POST">
                                            @csrf
                                            @if($errors->any())
                                            <div class="alert alert-dismissible alert-danger">
                                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                                               <a href="#" class="alert-link">Incorrect</a>  username or password <strong>!</strong>
                                            </div>
                                            @endif


                                            <div class="form-group">
                                                <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control form-control-user   @error('user_name') is-invalid @enderror"
                                                    id="exampleInputuser_name" aria-describedby="user_name_Help"
                                                    placeholder="User Name Here">

                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user  @error('password') is-invalid @enderror"
                                                    id="exampleInputPassword" placeholder="Password Here">

                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </form>
                                        <hr>

                                        <center>
                                            <a class="small text-left" href="{{ route('password.request') }}">Forgot Password?</a>
                                        </center>


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


