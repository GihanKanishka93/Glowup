@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <h1 class="h3 mb-2 text-gray-800">
        Upcoming Discharges
       </h1>

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
            <form id="backwardCountForm" class="row" >

                {{-- <div class="col-md-8 row"> --}}

                <label for="backward_day_count" class="col-md-2">Forward Day Count:</label>

                <div class="col-md-3">
                <input type="number" id="backward_day_count"   name="backward_day_count" value="{{ $day_count }}" class="form-control @error('backward_day_count') is-invalid @enderror">
                @error('backward_day_count')
                   <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
                   </span>
                @enderror
            </div>


            <div class="col-md-1">
                <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
            </div>
        {{-- </div> --}}
            </form>

            <div class="upcomming-date"><center> From :&nbsp; {{ $from_date }}   &nbsp;&nbsp;&nbsp;  To :&nbsp;  {{ $dis_toDate }}  </center></div>

            <div id="dataTableContainer">
            {{ $dataTable->table() }}
             </div>


        </div>
            </div>
        </div>
    </div>

@endsection

@section('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('plugin/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugin/datatable/dataTables.bootstrap4.min.css') }}">
@stop

@section('third_party_scripts')


    <!-- DataTables Buttons JS -->
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

$(document).ready(function() {
    $('#filterBtn').click(function() {
        var backward_day_count = $('#backward_day_count').val(); // Get the value from the text box

        // Construct the URL with the backward_day_count as a query parameter
    var url = '{{ route("report.upcoming-discharges-data") }}' + '?backward_day_count=' + backward_day_count;

        // Redirect to the constructed URL
        window.location.href = url;

    });
});


     </script>

<script>

</script>

@stop
