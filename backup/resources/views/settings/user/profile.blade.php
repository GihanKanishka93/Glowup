@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">
        {{ $user->user_name }} </h1>

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    {{-- <div class="dropdown no-arrow show">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $user->designation }} {{ $user->first_name }} {{ $user->last_name }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">Contact number</dt>
                        <dd class="col-sm-8">{{ $user->contact_number }}</dd>

                        <dt class="col-sm-4">User name</dt>
                        <dd class="col-sm-8">{{ $user->user_name }}</dd>

                        <dt class="col-sm-4">Roles</dt>
                        <dd class="col-sm-8">
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </dd>

                    </dl>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <form action="{{ route('change.password') }}" method="POST"> @csrf
                    @method('POST')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4">Current Password <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control   @error('current_password') is-invalid @enderror" id="current_password"
                                name="current_password" value="" placeholder="Current Password">
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">New Password : <i class="text-danger">*</i></label>
                                  <div class="col-sm-8">
                                      <input type="password" class="form-control   @error('new_password') is-invalid @enderror" id=""
                                          name="new_password" value="{{ old('new_password') }}"  placeholder="New Password">
                                      @error('new_password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Comfirm Password : <i class="text-danger">*</i></label>
                                  <div class="col-sm-8">
                                      <input type="password" class="form-control   @error('new_confirm_password') is-invalid @enderror"  
                                          name="new_confirm_password"  value="{{ old('new_confirm_password') }}" placeholder="Comfirm">
                                      @error('new_confirm_password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                    </div>


                </div>
                <div class="card-footer text-right">
                    <button type="submit" value="save" class="btn btn-sm btn-primary btn-icon-split">
                               <span class="icon text-white-50">
                                   <i class="fa fa-save"></i>
                               </span>
                               <span class="text">Save</span>
                           </button>
               </div>
           </form>
            </div>
        </div>

    </div>
 
@endsection
