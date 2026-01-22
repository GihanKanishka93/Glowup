@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Edit User</h1>
 
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between"> 
                    <div class="dropdown no-arrow show">
                       
                    </div>
                </div>
                <form method="post" action="{{ route('users.update',$user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">First Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('first_name') is-invalid @enderror" id="first_name"
                                    name="first_name" value="{{ $user->first_name }}" placeholder="First Name">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Last Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('last_name') is-invalid @enderror" id="last_name"
                                    name="last_name"  value="{{ $user->last_name }}" placeholder="Last Name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="email">Email: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ $user->email }}" placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
              
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="contact_number">Contact Number: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('contact_number') is-invalid @enderror" id="contact_number"
                                    name="contact_number"  value="{{ $user->contact_number }}" placeholder="Contact Number">
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
              
                        <div class="form-group row">
                          <label class="col-sm-2" for="designation">Designation:</label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control   @error('designation') is-invalid @enderror" id="designation"
                                  name="designation"  placeholder="Designation" value="{{ $user->designation }}">
                              @error('designation')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                         
                      </div>
                        <hr>
              
                        <div class="form-group row">
                            <label class="col-sm-2" for="user_name">User Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name" value="{{ $user->user_name }}" placeholder="User name">
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
               
              
                        </div>
                        <div class="form-group row">
              
                            <label class="col-sm-2" for="roles">Role: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="roles[]" id="roles" class="form-control multipel select2 @error('roles') is-invalid @enderror" multiple>
              
                                    @foreach ($role as $item)
                                        <option value="{{ $item->name }}"  @if(in_array($item->id, $userRoles)) @selected(true)   @endif  >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
               
                        </div>
                        
                    

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('users.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div> 
@endsection

@section('third_party_stylesheets')  
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/select2/select2.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@stop
