@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Monthly Report</h1>
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
                    <div class="box-body table-responsive">
                      
                        {{ $dataTable->table() }}

                    </div>
                    
                    <div class="alert alert-secondary" role="alert">
                        <i style="text-transform: none;">Attention: The above information is based on Room Occupancy input. Please note this when interpreting the data.</i>
                      </div>
                </div>
            </div>
        </div>
    @endsection

    @section('third_party_stylesheets')
        {{-- <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">  --}}
        <link rel="stylesheet" href="{{ asset('plugin/datatable/buttons.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/datatable/dataTables.bootstrap4.min.css') }}">
        <style>
            #monthlyreport-table_filter{
                display: none;
            }
        </style>
    @stop

    @section('third_party_scripts')
        <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugin/datatable/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('plugin/datatable/dataTables.bootstrap4.min.js') }}" defer></script>
        <script src="{{ asset('plugin/datatable/dataTables.buttons.min.js') }}" defer></script>
        <script src="{{ asset('plugin/vendor/datatables/buttons.server-side.js') }}" defer></script>
        {!! $dataTable->scripts() !!}

         <script>
             $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
         </script>
    @stop
