@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Add New User</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                       <div></div>
                </div>
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">First Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('first_name') is-invalid @enderror" id="first_name"
                                    name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Last Name:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('last_name') is-invalid @enderror" id="last_name"
                                    name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="email">Email:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="contact_number">Contact Number:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('contact_number') is-invalid @enderror" id="contact_number"
                                    name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number">
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
                                    name="designation" value="{{ old('designation') }}" placeholder="Designation">
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-2" for="user_name">User Name:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name" value="{{ old('user_name') }}" placeholder="User Name">
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="password">Password:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control   @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="confirm-password">Confirm Password:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control   @error('confirm-password') is-invalid @enderror"
                                    id="confirm-password" name="confirm-password" value="{{ old('confirm-password') }}"
                                    placeholder="Confirm password">
                                @error('confirm-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="roles">Role:<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="roles[]" id="roles" class="form-control multipel select2" multiple onchange="getUserRole();">
                                    <option value=""></option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->name }}" {{ in_array($item->name, old('roles', [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row doctor" style="display: none;">
                            <label class="col-sm-2" for="doctor">Select Doctor:</label>
                            <div class="col-sm-8">
                                <select name="doc_id" id="doc_id" class="form-control">
                                    <option value=""></option>
                                    @foreach ($doctor as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, old('doc_id', [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
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
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();

        function getUserRole(){
            var selectedValues =  $('#roles').val();

            const doctorDiv = document.querySelector('.form-group.row.doctor');

            if (selectedValues.includes('Doctor')) {
                doctorDiv.style.display = 'flex';
            } else {
                doctorDiv.style.display = 'none';
            }
        }


</script>
@stop
