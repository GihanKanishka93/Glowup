@extends('layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
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
                <form method="post" action="{{ route('users.update',2) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group row">
                            <label class="col-sm-2">First Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control   @error('first_name') is-invalid @enderror" id="first_name"
                                    name="first_name" value="" placeholder="First Name">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
              
                            <label class="col-sm-2">Last Name: <i class="text-danger">*</i></label>
                                      <div class="col-sm-4">
                                          <input type="text" class="form-control   @error('last_name') is-invalid @enderror" id="last_name"
                                              name="last_name"  value="" placeholder="Last Name">
                                          @error('last_name')
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

@section('third_party_stylesheets')  
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/select2/select2.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@stop
