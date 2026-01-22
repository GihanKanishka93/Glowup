@extends('layouts.app')
@section('content')
    <x-list-page title="Billing Summary" :back-route="url()->previous()" subtitle="From {{ $start_date }} to {{ $end_date }}">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="stat-chip">
                    <span class="label">Number of Bills</span>
                    <span class="value">{{ $total_records }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <span class="label">Total Billing Amount</span>
                    <span class="value">{{ number_format($total_amount, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>

        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>
@endsection

    @section('third_party_stylesheets')
        <link rel="stylesheet" href="{{ asset('plugin/datatable/buttons.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/datatable/dataTables.bootstrap4.min.css') }}">
    @stop

    @section('third_party_scripts')
        <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugin/datatable/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('plugin/datatable/dataTables.bootstrap4.min.js') }}" defer></script>
        <script src="{{ asset('plugin/datatable/dataTables.buttons.min.js') }}" defer></script>
        <script src="{{ asset('plugin/vendor/datatables/buttons.server-side.js') }}" defer></script>
        {!! $dataTable->scripts() !!}


    @stop
