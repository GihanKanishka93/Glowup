@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit User Role</h1>

<div class="row">
  <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
          <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
              <div class="dropdown no-arrow show">

              </div>
          </div>
          <form action="{{ route('role.update',$role->id) }}" method="post">
            @csrf
            @method('PUT')
              <div class="card-body">
                  <div class="form-group row">
                      <label class="col-sm-2" for="name">Role Name <i class="text-danger">*</i> </label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control   @error('name') is-invalid @enderror"
                              id="name" name="name" value="{{ $role->name }}" placeholder="Name">
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
                            @error('permission')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                              @foreach ($permissions as $value)
                                  <div class="col-md-4 " >

                                        <label class="label label-defalt">
                                          <input  class="form-check-input" type="checkbox" name="permission[]" @if(in_array($value->id, $rolePermissions)) @checked(true)  @endif id="" value="{{ $value->name }}">
                                        {{ $value->name }}</label>
                                  </div>
                              @endforeach
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













    {{-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">
              Edit</h1>
          </div>
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"></li>
              <li class="breadcrumb-item active">{{ $role->name}}</li>

            </ol>
          </div>
        </div>
      </div>
    </section> --}}
{{--
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-primary">{{ $role->name}}</h6>
        </div>
        <form action="{{ route('role.update',$role->id) }}" method="post">
          @csrf
          @method('PUT')
        <div class="card-body">
          <div class="form-group row">
            <label  class="col-sm-2" for="name">Name</label>
            <div class="col-sm-4">
            <input type="text" class="form-control   @error('name') is-invalid @enderror" id="name" name="name" value="{{ $role->name }}" placeholder="name">
          @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
            </div>
          </div>


          <div class="form-group  ">
            <label  class="col-sm-2 @error('permission') is-invalid @enderror" for="name">Permission</label>
            @error('permission')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="row ">

            @foreach($permissions as $value)
            <div class="col-md-4">
                <label class="label label-defalt">
                  <input type="checkbox" name="permission[]" @if(in_array($value->id, $rolePermissions)) @checked(true)  @endif id="" value="{{ $value->name }}">
                {{ $value->name }}</label>
              </div>
            @endforeach
          </div>
        </div>


    </div>
    <div class="card-footer">
         <button type="submit" value="save" class="btn btn-sm btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Save</span>
                                </button>
    </div>
    </form>
      </div>

    </section>  --}}
@endsection
