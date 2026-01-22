@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <x-list-page title="Upcoming Discharges" :back-route="url()->previous()">
        <form id="backwardCountForm" class="row g-3 align-items-end mb-3">
            <div class="col-sm-3">
                <label for="backward_day_count" class="form-label">Forward Day Count</label>
                <input type="number" id="backward_day_count" name="backward_day_count" value="{{ $day_count }}" class="form-control @error('backward_day_count') is-invalid @enderror">
                @error('backward_day_count')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-sm-2">
                <button type="button" id="filterBtn" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-sm-4 ms-auto text-sm-end">
                <div class="upcomming-date">From {{ $from_date }} to {{ $dis_toDate }}</div>
            </div>
        </form>

        <div id="dataTableContainer">
            {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
        </div>
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

    <script>
        $('table').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('#filterBtn').click(function() {
                const backward_day_count = $('#backward_day_count').val();
                const url = '{{ route("report.upcoming-discharges-data") }}' + '?backward_day_count=' + backward_day_count;
                window.location.href = url;
            });
        });
    </script>
@stop
