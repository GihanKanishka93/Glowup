@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">
        District wise patients
       </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="dropdown no-arrow show">
                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-info btn-icon-split">
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
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script>
         $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
    </script>
@stop
