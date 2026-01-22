@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">All Rooms</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">Forms</h6> --}}
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('room.index') }}" class="btn btn-md btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                    <div>
                        @can('room-create')
                            <a href="{{ route('room.create') }}" class="btn btn-md btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fa fa-plus"></i>
                                </span>
                                <span class="text">Add New Room</span>
                            </a>
                        @endcan
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
         $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
   // In your JavaScript file or inline script
$(document).on('click', '.delete-btn', function () {
    var itemId = $(this).data('id'); 
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var id =  '#del'+itemId;
            $(id).submit();
        }
    });
});

    </script>
@stop
