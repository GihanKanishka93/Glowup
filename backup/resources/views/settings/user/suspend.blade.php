@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Deleted Users</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 
                    <div class="dropdown no-arrow show">
                        <a href="{{ URL::previous() }}" class="btn btn-md btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('third_party_stylesheets')
    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style> body {
      text-transform: none !important; /* or any other value you want */
  }
  </style> 
@stop

@section('third_party_scripts')
    {{-- <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script>
       $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
    </script>
@stop


{{-- 
@extends('layouts.app')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">Suspend users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Users</li>
              <li class="breadcrumb-item active">Suspend</li>
            </ol>
          </div>
        </div>
      </div> 
    </section>
 
    <section class="content"> 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            {{-- <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New</a>   --
            </h3> 
            <div class="card-tools">
              <a href="{{ URL::previous() }}" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
          {{ $dataTable->table(); }}
        </div>  
      </div> 

    </section> 
@endsection

@section('third_party_stylesheets') 

<link href="{{ asset('plugin/datatable/dataTables.bootstrap4.min.css'); }}" rel="stylesheet">
@stop

@section('third_party_scripts') 
<script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}" ></script>
{!! $dataTable->scripts() !!} 
@stop --}}


