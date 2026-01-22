@extends('layouts.app')
@section('content')
    <x-list-page title="All Users" :back-route="url()->previous()">
        <x-slot:actions>
            @can('user-create')
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Add User
                </a>
            @endcan
        </x-slot:actions>

        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>
@endsection

@section('third_party_stylesheets')
    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style>
        .lowercase {
    text-transform: lowercase !important;
}
body {
    text-transform: none !important; /* or any other value you want */
}
    </style>
    {{-- <link rel="stylesheet" href="{{ asset('plugin/datatables/dataTables.bootstrap4.min.css') }}"> --}}
@stop

@section('third_party_scripts')
    {{-- <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
     $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
   // In your JavaScript file or inline script
   document.body.classList.remove('example-class');
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
