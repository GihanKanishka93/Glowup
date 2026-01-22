@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Create User Role</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between"> 
                    <div class="dropdown no-arrow show">
                      
                    </div>
                </div>
                <form action="{{ route('role.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2" for="name">Role Name <i class="text-danger">*</i> </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group  row">
                            <label class="col-sm-2   " for="name">Permissions
                                <i class="text-danger">*</i></label>
                           
                            <div class="col-sm-10">

                
                                <div class="row " style="margin-left: 3px">
                                  <input type="text" class=" d-none @error('permission') is-invalid @enderror   ">
                                
                                    @foreach ($permissions as $value)
                                        <div class="col-md-4 form-check">
                                            <label class="label label-defalt">
                                                <input class="form-check-input" type="checkbox" name="permission[]" id=""
                                                    value="{{ $value->name }}" class="@error('permission') is-invalid @enderror  ">
                                                {{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('permission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                   @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('role.index') }}" class="btn btn-info">
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
