@extends('layouts.app')
@section('content')
    <x-list-page title="Province-wise Patients" :back-route="url()->previous()">
        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>
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
