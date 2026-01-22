@extends('layouts.app')
@section('content')
    <x-list-page title="Sample Users" :back-route="url()->previous()">
        <x-slot:actions>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>New
            </a>
        </x-slot:actions>

        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>
@endsection

@section('third_party_stylesheets')
    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('plugin/datatables/dataTables.bootstrap4.min.css') }}"> --}}
@stop

@section('third_party_scripts')
    {{-- <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
@stop
